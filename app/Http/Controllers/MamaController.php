<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $prices = \App\Models\HistoricalPrice::with('company')
            ->where('date', $latestDate->latest_date)
            ->orderBy('company_id','asc')
            ->get();

        $prices = $prices->filter(function ($price) {
            return $price->low > $price->alma
                && $price->macd_hist > 0
                && $price->value > 10**6
                && ($price->close / $price->alma) + 0.01195 < 1.05;
        });

        return view('prices', compact('prices'));
    }
}
