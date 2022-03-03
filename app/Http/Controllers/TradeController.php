<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Portfolio;
use App\Models\Trade;
use Carbon\Carbon;
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
        $trades = Trade::where('trade_type','buy')
            ->orderByDesc('date')
            ->where('user_id', auth()->id())
            ->get();

        return view('trades.index', compact('trades'))
            ->with([
                'companies' => Company::select('id','symbol')->get(),
                'trade_types' => Trade::TRADE_TYPES
                ]);
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
            'target_price' => 'required|numeric',
            'cut_loss' => 'required|numeric',
            'remarks' => 'nullable',
        ]);

        // validate first if transaction is sell
        if ($request->trade_type == 'sell') {
            $portfolio = auth()->user()->portfolios()->where('company_id', $request->company_id)->first();

            if (! $portfolio) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not own shares from this stock'
                ], 200);
            }

            if ($portfolio->shares < $request->shares) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not own sufficient shares for that transaction',
                ]);
            }
        }

        Trade::create($request->all());

        if ($request->trade_type == 'sell') {
            $portfolio = auth()->user()->portfolios()->where('company_id', $request->company_id)->first();

            $portfolio->update([
                'shares' => $portfolio->shares - $request->shares
            ]);
        } else {
            $portfolio = auth()->user()->portfolios()->where('company_id', $request->company_id)->first();

            if ($portfolio) {
                $portfolio->update([
                    'shares' => $portfolio->shares + $request->shares
                ]);
            } else {
                auth()->user()->portfolios()->save(new Portfolio([
                    'company_id' => $request->company_id,
                    'shares' => $request->shares
                ]));
            }
        }

        if (! auth()->user()->watchlists()->where('company_id', $request->company_id)->exists()) {
            // add to watchlist
            auth()->user()->watchlists()
                ->create([
                    'company_id'    => $request->company_id,
                    'remarks'       => 'bought stock on ' . (string) $request->date,
                ]);
        }

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
            'target_price' => 'required|numeric',
            'cut_loss' => 'required|numeric',
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
