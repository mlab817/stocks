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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/companies/{company}/historical_prices', function ($company) {
    $company = \App\Models\Company::where('symbol', $company)->first();

    return response()->json($company->prices()->select('date','open','high','low','close','value')->orderBy('date','asc')->get());
})->name('api.get_prices');
