<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TitaController extends Controller
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

        $prices = \App\Models\HistoricalPrice::with('company')
            ->where('date', $latestDate->latest_date)
            ->orderBy('company_id','asc')
            ->get();

        $prices = $prices->filter(function ($price) {
//            return $price->rsi == 50 || $price->rsi == 55
//                && $price->alma < $price->low;
            return $price;
        });

        return view('tita', compact('prices'))
            ->with('latest_date', $latestDate->latest_date);
    }
}
