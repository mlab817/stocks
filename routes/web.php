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

Route::resource('companies.historical_prices', \App\Http\Controllers\HistoricalPriceController::class);
Route::resource('companies',\App\Http\Controllers\CompanyController::class);
Route::resource('trades',\App\Http\Controllers\TradeController::class);

Route::get('/mama', function () {
    $prices = \App\Models\HistoricalPrice::with('company')
        ->where('date',\Carbon\Carbon::today())
        ->orderBy('company_id','asc')
        ->get();

    return view('prices', compact('prices'));
});
