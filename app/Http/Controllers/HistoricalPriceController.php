<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\HistoricalPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricalPriceController extends Controller
{
    public function index(Company $company)
    {
        $prices = $company
            ->prices()
            ->where(DB::raw('EXTRACT(YEAR FROM date)'), '>=', '2021')
            ->orderBy('date','asc')
            ->get();

        return view('companies.prices.index', compact('prices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'date' => 'required',
            'open' => 'nullable',
            'high' => 'nullable',
            'low' => 'nullable',
            'close' => 'nullable',
            'value' => 'nullable',
            'alma' => 'nullable',
            'macd' => 'nullable',
            'macd_signal' => 'nullable',
            'macd_hist' => 'nullable',
            'ma_20' => 'nullable',
            'ma_50' => 'nullable',
            'ma_100' => 'nullable',
            'ma_200' => 'nullable',
            'rsi' => 'nullable',
            'cci' => 'nullable',
            'atr' => 'nullable',
            'sts' => 'nullable',
            'williams_r' => 'nullable',
            'trix' => 'nullable',
            'psar' => 'nullable',
            'ema_9' => 'nullable',
        ]);

        $historicalPrice = HistoricalPrice::create($request->all());

        if ($historicalPrice) {
            return 'Successfully created resource';
        }

        return 'Something went wrong';
    }

    public function destroy(HistoricalPrice $price)
    {
        if ($price->delete()) {
            return back()
                ->with('success','Successfully deleted');
        }

        return 'Something went wrong';
    }
}
