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

        Trade::create($request->all());

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
    public function edit(Trade $trade)
    {
        return view('trades.edit', compact('trade'))
            ->with('trade_types', Trade::TRADE_TYPES)
            ->with('companies', Company::select('id','symbol')->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trade $trade)
    {
        $request->validate([
            'trade_type' => 'required|in:' . implode(',',Trade::TRADE_TYPES),
            'company_id' => 'required|exists:companies,id',
            'date' => 'required|date',
            'shares' => 'required|int',
            'price' => 'required|numeric',
            'remarks' => 'nullable',
        ]);

        $trade->update($request->all());

        return redirect()->route('trades.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trade $trade)
    {
        $trade->delete();

        return redirect()->route('trades.index');
    }
}
