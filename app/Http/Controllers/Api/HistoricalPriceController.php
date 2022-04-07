<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HistoricalPriceStoreRequest;
use App\Models\Company;
use App\Models\HistoricalPrice;
use Illuminate\Http\Request;

class HistoricalPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param HistoricalPriceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(HistoricalPriceStoreRequest $request)
    {
        $company = Company::where('id', $request->company_id)->first();

        if (HistoricalPrice::where('company_id', $request->company_id)
            ->where('date', $request->date)->exists()) {

            // update the timestamp
            $company->touch();


            return response()->json([
                'success' => false,
                'message' => 'Record already exists'
            ], 200);
        }

        $price = HistoricalPrice::create($request->validated());

        $company->touch();

//        $price->indicator()->create($request->all());

        if (! $price) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while inserting data'
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully added record'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HistoricalPrice $price)
    {
        return response()->json($price, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HistoricalPrice $price)
    {
        $price->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $price
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HistoricalPrice $price)
    {
        $price->delete();

        return response()->json([
            'success' => true,
            'data' => null
        ], 200);
    }
}
