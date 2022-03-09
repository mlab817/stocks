<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompanyPriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (! $symbol = $request->symbol) {
            return response()->json(['message' => 'Stock symbol is required'], 404);
        }

        $company = Company::findBySymbol($symbol);

        $prices = $company->prices();

        if ($start_date = $request->start_date) {
            $prices = $prices->where('date', '>=', $start_date);
        }

        $prices = $prices->orderBy('date')->select('date','open','high','low','close','value')->get();

        return response()->json([
            'company'       => $company,
            'prices'        => $prices,
            'indicators'    => null
        ]);
    }
}
