<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BopisController extends Controller
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
            return $price->ema_9 && $price->low > $price->ema_9
                && $price->psar && $price->low > $price->psar
                && $price->trix && abs($price->trix) <= 0.1;
        });

        return view('bopis', compact('prices'));
    }
}
