<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return response()->json(['user' => $request->user()]);
})->middleware('auth:api');

Route::get('/stockData', \App\Http\Controllers\Api\CompanyPriceController::class);

Route::get('/companies/{company}/historical_prices', function ($company) {
    $company = \App\Models\Company::where('symbol', $company)->first();

    return response()->json($company->prices()->select('date','open','high','low','close','value')->orderBy('date')->get());
})->name('get_prices');

Route::get('/companies/{company}', function ($company) {
    $company = \App\Models\Company::where('symbol', $company)->first();

    return new \App\Http\Resources\CompanyResource($company->load('prices'));
});

Route::post('/search', function (Request $request) {
    $search = strtolower($request->search);

    $companies = \App\Models\Company::where(\Illuminate\Support\Facades\DB::raw('LOWER(symbol)'),'like', $search . '%')->select('symbol','name')->get();

    return response()->json($companies);
})->name('api.search');

Route::resource('historical_prices', \App\Http\Controllers\Api\HistoricalPriceController::class);

Route::resource('companies', \App\Http\Controllers\Api\CompanyController::class);

Route::apiResource('trades', \App\Http\Controllers\Api\TradeController::class);

Route::get('/mama', \App\Http\Controllers\Api\MamaController::class)->name('api.mama');
Route::get('/portfolio', \App\Http\Controllers\Api\PortfolioController::class);

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:api');

Route::get('/stockList', [\App\Http\Controllers\Api\CompanyController::class,'stockList']);
