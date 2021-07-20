<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidFormatException;
use App\Http\Requests\ParseCSVRequest;
use App\Http\Requests\StoreRequest;
use App\Http\Services\CSVService;
use App\Models\Csv;
use App\Models\Header;
use App\Models\Line;
use App\Models\Value;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CsvController extends Controller
{
    /**
     * Display a list of stored CSV files.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $csvs = Csv::all();
        return view('index', ['csvs' => $csvs]);
    }

    /**
     * Store CSV data.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $header = unserialize($request->get('header'));
        $data = unserialize($request->get('data'));

        DB::beginTransaction();
        try {
            $csv = new Csv();
            $csv->title = $validated['title'];
            $csv->save();

            $headers = [];
            foreach ($header as $idx => $item) {
                $h = new Header();
                $h->name = $item[CSVService::COL_NAME];
                $h->type = $item[CSVService::COL_TYPE];
                $h->order = $idx;

                $h->csv()->associate($csv);
                $h->save();

                $headers[] = $h;
            }

            foreach ($data as $row => $line) {
                $l = new Line();
                $l->order = $row;
                $l->csv()->associate($csv);
                $l->save();

                foreach ($line as $col => $value) {
                    $v = new Value();
                    $v->value = $value;

                    $v->line()->associate($l);
                    $v->header()->associate($headers[$col]);
                    $v->save();
                }
            }

            DB::commit();
            return redirect()->route('show', $csv->id);
        } catch (Exception) {
            DB::rollBack();
            var_dump($data);
            return redirect()->back()
                ->withInput(['header' => $header, 'data' => $data])
                ->withErrors(['save-fail' => 'Save failed.']);
        }
    }

    /**
     * Display stored CSV data.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id): View|Factory|Application
    {
        /** @var Csv|null $csv */
        $csv = Csv::find($id);

        if (!$csv) {
            throw new NotFoundHttpException();
        }

        $header = $csv->headers()
            ->orderBy('order')
            ->get();
        $lines = $csv->lines()
            ->with(['values', 'values.header'])
            ->orderBy('order')
            ->get();

        $data = [];
        foreach ($lines as $line) {
            $l = [];

            foreach ($line->values as $value) {
                $l[$value->header->order] = $value->value;
            }
            $data[] = $l;
        }

        return view('table', [
            'title' => $csv->title,
            'header' => $header,
            'data' => $data
        ]);
    }

    /**
     * Display form to upload CSV file.
     *
     * @return Factory|View|Application
     */
    public function upload(): Factory|View|Application
    {
        return view('upload_form');
    }

    /**
     * Parse and display uploaded CSV.
     * @param ParseCSVRequest $request
     * @param CSVService $CSVService
     * @return Application|Factory|View|RedirectResponse
     */
    public function parse(ParseCSVRequest $request, CSVService $CSVService): Application|Factory|View|RedirectResponse
    {
        $validated = $request->validated();

        $fileContent = $validated['csv']->getContent();

        try {
            $result = $CSVService->parse($fileContent, $validated['separator']);

            return redirect()
                ->route('result')
                ->withInput($result);

        } catch (InvalidFormatException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['csv' => $e->getMessage()]);
        }
    }

    public function result(Request $request): Application|Factory|View|RedirectResponse
    {
        $input = session()->getOldInput();

        if (!$input) {
            return redirect()->route('upload');
        }

        if (is_string($input['header'])) {
            $input['header'] = unserialize($input['header']);
        }

        if (is_string($input['data'])) {
            $input['data'] = unserialize($input['data']);
        }

        return view('table', $input);
    }

    /**
     * Concat first third columns into new column.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function concat(Request $request): RedirectResponse
    {
        $header = unserialize($request->get('header'));
        $data = unserialize($request->get('data'));

        $newName = $header[0]['name'] . ' ' . $header[2]['name'];
        $newType = $header[0]['type'] === $header[2]['type'] ? $header[0]['type'] : 'mixed';

        $header[] = ['name' => $newName, 'type' => $newType];

        foreach ($data as $idx => $line) {
            $concat = $line[0] . ' ' . $line[2];

            if (ctype_space($concat) || $concat === '') {
                $line[] = '[EMPTY]';
            } else {
                $line[] = $concat;
            }

            $data[$idx] = $line;
        }

        return redirect()
            ->route('result')
            ->withInput(['header' => $header, 'data' => $data]);
    }

}
