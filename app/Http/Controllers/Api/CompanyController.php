<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\HistoricalPrice;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company = new Company;

        // if q is sent
        if ($request->q) {
            $company = Company::search($request->q);
        }

        if ($request->sortBy) {
            $company = $company->orderBy('name', $request->descending ? 'desc' : 'asc');
        }

        $companies = $company->paginate($request->perPage ?? 15);

        $companies->load('subsector.sector');

        return response()->json($companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return response()->json([
            'basicInformation' => $company->load('subsector.sector'),
            'prices' => HistoricalPrice::select('date','open','high','low','close','value')
                ->where('company_id', $company->id)
                ->orderBy('date')
                ->get(),
            'indicators' => HistoricalPrice::where('company_id', $company->id)->orderByDesc('date')->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function stockList()
    {
        $companies = Company::select('id','symbol', 'name')
            ->orderBy('symbol')
            ->get();

        return response()->json($companies);
    }
}
