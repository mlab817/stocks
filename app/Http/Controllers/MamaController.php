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
        $latestDates = \Illuminate\Support\Facades\DB::table('historical_prices')
            ->selectRaw('DISTINCT(date) AS unique_date')
            ->orderByDesc('date')
            ->limit(2)
            ->get();

        $latestDates = $latestDates->sortBy('unique_date')->pluck('unique_date')->toArray();

        $query = 'select * from (
                    select *,
                           lag(macd_hist) over(partition by company_id order by date asc) lag_macd_hist
                    from historical_prices where date >= ?
                ) tab1 where date=?';

        $prices = DB::select($query, $latestDates);

        $prices = HistoricalPrice::hydrate($prices);
        $prices->load('company.latest_price');

//        $prices = $prices->filter(function($price) {
//            return $price->recommendation == HistoricalPrice::BUY
//                || $price->recommendation == HistoricalPrice::SELL;
//        });

        return view('mama', compact('prices','latestDates'));
    }
}
