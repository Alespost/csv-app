<?php


namespace App\Http\Services;


use App\Exceptions\InvalidFormatException;
use JetBrains\PhpStorm\ArrayShape;

class CSVService
{
    public const COL_NAME = 'name';
    public const COL_TYPE = 'type';

    private const MIN_COLS = 3;
    private const MAX_COLS = 10;

    private const LINE_IDX_ADDITIVE = 2;

    private TypeService $typeService;

    /**
     * CSVService constructor.
     * @param TypeService $typeService
     */
    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }

    /**
     * Parse CSV data.
     *
     * @param string $content CSV data
     * @param string $separator Column separator.
     * @return array
     * @throws InvalidFormatException
     */
    #[ArrayShape(['header' => "array", 'data' => "array"])]
    public function parse(string $content, string $separator): array
    {
        $lines = explode(PHP_EOL, $content);

        $headers = str_getcsv(array_shift($lines), $separator);
        $headers = array_map(array($this, 'mapHeader'), $headers);

        $headerColCount = count($headers);
        if ($headerColCount < self::MIN_COLS || $headerColCount > self::MAX_COLS) {
            throw new InvalidFormatException(
                'The number of columns is out of range <'
                . self::MIN_COLS
                . ';'
                . self::MAX_COLS
                . '>.'
            );
        }

        $data = [];
        foreach ($lines as $idx => $line) {
            if ($line == '') {
                continue;
            }

            $values = str_getcsv($line, $separator);

            $currentColCount = count($values);
            if ($currentColCount != $headerColCount) {
                throw new InvalidFormatException(
                    'Line ' . $idx + self::LINE_IDX_ADDITIVE
                    . ': The number of columns (' . $currentColCount
                    . ') does not match the number of columns in the header ('
                    . $headerColCount .').'
                );
            }

            $data[] = $values;

            foreach ($values as $index => $value) {
                $type = $this->typeService->getType($value);

                if ($headers[$index][self::COL_TYPE] === '') {
                    $headers[$index][self::COL_TYPE] = $type;
                } else if ($headers[$index][self::COL_TYPE] !== $type) {
                    $headers[$index][self::COL_TYPE] = 'mixed';
                }
            }
        }

        return ['header' => $headers, 'data' => $data];

    }

    #[ArrayShape([self::COL_NAME => "", self::COL_TYPE => "string"])]
    private function mapHeader($name): array
    {
        return [
            self::COL_NAME => $name,
            self::COL_TYPE => '',
        ];
    }
}
