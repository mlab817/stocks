<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TradeRequest;
use App\Models\Portfolio;
use App\Models\Trade;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        return response()->json($user->trades->load('user','company'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TradeRequest $request)
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
                ], 422);
            }

            if ($portfolio->shares < $request->shares) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not own sufficient shares for that transaction',
                ], 422);
            }
        }

        $trade = Trade::create($request->all());

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

        return response()->json([
            'success' => true,
            'data' => $trade
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Trade $trade)
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
    public function update(TradeRequest $request, Trade $trade)
    {
        $trade->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $trade
        ]);
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

        return response()->json([
            'success' => true,
            'data' => null
        ]);
    }
}
