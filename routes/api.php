<?php

use App\Http\Resources\HistoricalPriceResource;
use App\Models\HistoricalPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

Route::resource('historical_prices', \App\Http\Controllers\Api\HistoricalPriceController::class);

Route::resource('companies', \App\Http\Controllers\Api\CompanyController::class);

Route::apiResource('trades', \App\Http\Controllers\Api\TradeController::class);

Route::get('/mama', \App\Http\Controllers\Api\MamaController::class)->name('api.mama');
Route::resource('/portfolios', \App\Http\Controllers\Api\PortfolioController::class);

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:api');

Route::get('/stockList', [\App\Http\Controllers\Api\CompanyController::class,'stockList']);

Route::get('/getStockList', [\App\Http\Controllers\Api\PythonController::class,'getStockList']);

Route::get('/latestPrice', function () {
    $maxDate = \Illuminate\Support\Facades\DB::table('historical_prices')->selectRaw('MAX(date) as last_date')->first();
    $prices = \Illuminate\Support\Facades\DB::table('historical_prices as a')
        ->select('b.symbol', 'a.company_id', 'a.close')
        ->where('date','=', $maxDate->last_date)
        ->join('companies as b','a.company_id','=','b.id')
        ->get()
        ->map(function ($p) {
            return [
                'symbol' => $p->symbol,
                'company_id' => $p->company_id,
                'close' => floatval($p->close),
            ];
        });

    return response()->json([
        'lastDate' => $maxDate->last_date,
        'prices' => $prices
    ]);
});

Route::get('/tita', function () {
    $latestDate = \Illuminate\Support\Facades\DB::table('historical_prices')
        ->select(DB::raw('MAX(date) AS latest_date'))
        ->first();

    $prices = \App\Http\Resources\TitaResource::collection(HistoricalPrice::with('company')
        ->where('date', $latestDate->latest_date)
        ->get());

    return response()->json([
        'prices'        => $prices,
        'latestDate'    => $latestDate->latest_date
    ]);
});

Route::post('/calculate-indicators', function (\Illuminate\Http\Request $request) {
    $service = new \App\Services\CalculateIndicatorsService($request->symbol);
    return $service->execute();
});
