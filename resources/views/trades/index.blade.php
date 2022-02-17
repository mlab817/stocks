@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3 text-end">
            <div>
                <a href="{{ route('trades.create') }}" class="btn btn-primary">Add</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th class="text-center">Stock</th>
                    <th class="text-end">No. of Shares</th>
                    <th class="text-end">Price per Share</th>
                    <th class="text-end">Total Cost</th>
                    <th class="text-end">Ave. Cost</th>
                    <th class="text-end">
                        Breakeven Price
                    </th>
                    <th class="text-end">
                        Latest Price
                    </th>
                    <th class="text-center">
                        Remarks
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($trades as $trade)
                    <tr>
                        <td>
                            {{ $trade->date }}
                        </td>
                        <td class="text-center">
                            {{ $trade->company->symbol }}
                        </td>
                        <td class="text-end">
                            {{ $trade->shares }}
                        </td>
                        <td class="text-end">
                            {{ number_format($trade->price, 2) }}
                        </td>
                        <td class="text-end">
                            {{ number_format($trade->total_cost, 2) }}
                        </td>
                        <td class="text-end">
                            {{ number_format($trade->total_cost / $trade->shares, 2) }}
                        </td>
                        <td class="text-end">
                            {{ number_format($trade->breakeven_price, 2) }}
                        </td>
                        <td class="text-end">
                            {{ number_format($trade->company->latest_price->close, 2) }}
                        </td>
                        <th class="text-center">
                            {{ $trade->remarks }}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
