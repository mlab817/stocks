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

    public function destroy($id)
    {
        $price = HistoricalPrice::findOrFail($id);

        if ($price->delete()) {
            return back()
                ->with('success','Successfully deleted');
        }

        return 'Something went wrong';
    }
}
