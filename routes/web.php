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
Route::resource('historical_prices', \App\Http\Controllers\HistoricalPriceController::class);
Route::resource('trades',\App\Http\Controllers\TradeController::class)->middleware('auth');

Route::get('/calculator', \App\Http\Controllers\CalculatorController::class)->name('calculator');

Route::get('/fundamentals', [\App\Http\Controllers\CompanyController::class,'fundamentals'])->name('fundamentals');

Route::get('/portfolio', \App\Http\Controllers\PortfolioController::class)->name('portfolio');

Route::get('/mama', \App\Http\Controllers\MamaController::class)->name('mama');

Route::get('/bopis', \App\Http\Controllers\BopisController::class)->name('bopis');

Route::get('/tita', \App\Http\Controllers\TitaController::class)->name('tita');

Route::delete('/watchlists', [\App\Http\Controllers\WatchlistController::class,'destroy'])->name('watchlists.destroy');
Route::resource('watchlists', \App\Http\Controllers\WatchlistController::class)->only('index','store','update');

Route::resource('cash_transactions', \App\Http\Controllers\CashTransactionController::class);

Route::get('/upload', function () {
    return view('upload');
})->name('upload.show');

Route::post('/upload', function (\Illuminate\Http\Request $request) {
    $file = $request->file('file');

    (new \App\Imports\HistoricalPricesImport)
        ->import($file, '', \Maatwebsite\Excel\Excel::CSV);

    return back();

})->name('upload.post');
