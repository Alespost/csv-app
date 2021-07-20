<?php

use App\Http\Controllers\CsvController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('index');
});

Route::prefix('csv')->group(function () {

    Route::get('/', [CsvController::class, 'index'])
        ->name('index');

    Route::get('/{id}', [CsvController::class, 'show'])
        ->where('id', '\d+')
        ->name('show');


    Route::get('/upload', [CsvController::class, 'upload'])
        ->name('upload');

    Route::post('/upload', [CsvController::class, 'parse'])
        ->name('csv-parse');

    Route::get('/result', [CsvController::class, 'result'])
        ->name('result');

    Route::post('/concat', [CsvController::class, 'concat'])
        ->name('concat');

    Route::post('/store', [CsvController::class, 'store'])
        ->name('store');

});
