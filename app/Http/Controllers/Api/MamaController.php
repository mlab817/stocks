<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        return response()->json([
            'prices'        => $prices,
            'latestDate'    => $latestDate->latest_date
        ]);
    }
}
