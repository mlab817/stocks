<?php

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

Route::redirect('/', '/home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('companies', \App\Http\Controllers\CompanyController::class);
Route::delete('/historical_prices/{historical_price}', [\App\Http\Controllers\HistoricalPriceController::class,'destroy'])->name('historical_prices.destroy');
Route::resource('trades',\App\Http\Controllers\TradeController::class);

Route::get('/mama', \App\Http\Controllers\MamaController::class)->name('mama');

Route::get('/upload', function () {
    return view('upload');
})->name('upload.show');

Route::post('/upload', function (\Illuminate\Http\Request $request) {
    $file = $request->file('file');

    (new \App\Imports\HistoricalPricesImport)
        ->import($file, '', \Maatwebsite\Excel\Excel::CSV);

    return back();

})->name('upload.post');
