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

    public function destroy(HistoricalPrice $price)
    {
        $price->delete();

        return back();
    }
}
