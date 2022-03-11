<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Portfolio;
use App\Services\CalculateCostService;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(['portfolios'=>auth()->user()->portfolios->load('user','company')], 200);
    }

    public function store(Request $request, CalculateCostService $service)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'shares'     => 'required|int|gt:0',
            'price'      => 'required|numeric|gt:0',
        ]);

        $portfolio = auth()->user()->portfolios()->updateOrCreate([
            'company_id'    => $request->company_id,
        ],[
            'company_id'    => $request->company_id,
            'shares'        => $request->shares,
            'price'         => $request->price,
            'total_cost'    => $request->shares * $request->price,
        ]);

        return response()->json([
            'message'   => 'Sucessfully added portfolio entry',
            'portfolio' => $portfolio
        ]);
    }

    public function update(Request $request, Portfolio $portfolio, CalculateCostService $service)
    {
        $request->validate([
            'shares'     => 'required|int|gt:0',
            'price'      => 'required|numeric|gt:0',
        ]);

        $portfolio->update([
            'shares'        => $request->shares,
            'price'         => $request->price,
            'total_cost'    => $request->shares * $request->price,
        ]);

        return response()->json([
            'message'   => 'Sucessfully updated portfolio entry',
            'portfolio' => $portfolio
        ]);
    }

    public function destroy(Request $request, Portfolio $portfolio)
    {
        $portfolio->delete();

        return response()->json([
            'message' => 'Successfully deleted portfolio entry',
        ]);
    }
}
