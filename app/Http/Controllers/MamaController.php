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
            ->select(DB::raw('MAX(date) AS latest_date'))
            ->first();

        $prices = HistoricalPrice::with('company')
            ->where('date', $latestDate->latest_date)
            ->get();

//        $prices = $prices->filter(function($price) {
//            return $price->recommendation == HistoricalPrice::BUY
//                || $price->recommendation == HistoricalPrice::SELL;
//        });

        return view('mama', compact('prices'))
            ->with('latestDate', $latestDate->latest_date);
    }
}
