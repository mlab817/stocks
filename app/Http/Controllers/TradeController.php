<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Trade;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trades = Trade::where('trade_type','buy')->get();

        return view('trades.index', compact('trades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::orderby('symbol')->get();
        $trade_types = Trade::TRADE_TYPES;

        return view('trades.create', compact('companies','trade_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'trade_type' => 'required|in:' . implode(',',Trade::TRADE_TYPES),
            'company_id' => 'required|exists:companies,id',
            'date' => 'required|date',
            'shares' => 'required|int',
            'price' => 'required|numeric',
            'remarks' => 'nullable',
        ]);

//        trade_type
//        company_id
//        shares
//        date
        $base_cost = $request->price * $request->shares;
        $commission = $base_cost * 0.0025;
        $vat = $commission * 0.12;
        $sccp_fee = $base_cost * 0.0001;
        $pse_fee = $base_cost * 0.00005;

        if ($request->trade_type == 'sell') {
            $sales_tax = $base_cost * 0.006;
        } else {
            $sales_tax = 0;
        }

        $trade = Trade::create($request->all());
        $trade->commission = $commission;
        $trade->vat = $vat;
        $trade->sccp_fee = $sccp_fee;
        $trade->pse_fee = $pse_fee;
        $trade->sales_tax = $sales_tax;
        $trade->user_id = auth()->id() ?? 1;
        $trade->save();

        return redirect()->route('trades.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
