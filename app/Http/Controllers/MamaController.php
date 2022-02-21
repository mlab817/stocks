<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\HistoricalPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MamaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $latestDate = \Illuminate\Support\Facades\DB::table('historical_prices')
            ->selectRaw('MAX(date) as latest_date')
            ->first();

        $companies = Company::active()->get()->pluck('id');

        $query = 'WITH cte AS (
                SELECT a.date,
                a.open,
                a.high,
                a.low,
                a.close,
                a.value,
                a.alma,
                a.macd_hist,
                b.symbol,
                CAST(LAG(macd_hist) OVER (PARTITION BY company_id ORDER BY date ASC) AS DECIMAL) AS lag_macd_hist
             FROM historical_prices a
             JOIN companies b ON a.company_id = b.id
        ) SELECT * FROM cte WHERE date=?';

        $prices = DB::select($query, [$latestDate->latest_date]);

        $prices = HistoricalPrice::hydrate($prices);

        return view('mama', compact('prices'));
    }
}
