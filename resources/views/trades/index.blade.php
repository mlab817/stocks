@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3 text-end">
            <div>
{{--                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addTradeModal">--}}
{{--                    Add--}}
{{--                </a>--}}
                <a href="{{ route('trades.create') }}" class="btn btn-primary">
                    Add
                </a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
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
                    <th>

                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($trades as $trade)
                    <tr>
                        <td>
                            <a href="{{ route('trades.edit', $trade) }}" class="btn btn-sm btn-secondary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
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
                        <th>
                            <form action="{{ route('trades.destroy', $trade) }}" class="form-inline" method="post" onsubmit="return confirm('Are you sure you want to delete this?')">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-x-circle-fill"></i>
                                </button>
                            </form>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Logout Modal-->
{{--    <div class="modal fade" id="addTradeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
{{--         aria-hidden="true">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="exampleModalLabel">Add Trade</h5>--}}
{{--                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">×</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <form id="storeTradeForm" action="{{ route('trades.store') }}" method="POST" accept-charset="UTF-8">--}}
{{--                        @csrf--}}
{{--                        <label for="trade_type" class="form-label required">Buy or Sell</label>--}}
{{--                        <select class="form-control" id="trade_type" name="trade_type">--}}
{{--                            <option value="">Select One</option>--}}
{{--                            @foreach($trade_types as $trade_type)--}}
{{--                                <option value="{{ $trade_type }}">--}}
{{--                                    {{ strtoupper($trade_type) }}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}

{{--                        <label for="company_id" class="form-label mt-3 required">Stock</label>--}}
{{--                        <select class="form-control" id="company_id" name="company_id">--}}
{{--                            <option value="">Select One</option>--}}
{{--                            @foreach($companies as $company)--}}
{{--                                <option value="{{ $company->id }}">--}}
{{--                                    {{ $company->symbol }}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}

{{--                        <label for="date" class="form-label mt-3 required">Date</label>--}}
{{--                        <input type="date" id="date" name="date" class="form-control">--}}

{{--                        <label for="shares" class="form-label mt-3 required">No. of Shares</label>--}}
{{--                        <input type="number" id="shares" name="shares" class="form-control" step="1">--}}

{{--                        <label for="price" class="form-label mt-3 required">Price per Share</label>--}}
{{--                        <input type="number" id="price" name="price" class="form-control" step="0.01">--}}

{{--                        <label for="remarks" class="form-label mt-3">Remarks</label>--}}
{{--                        <textarea name="remarks" id="remarks" class="form-control"></textarea>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>--}}
{{--                    <button type="submit" class="btn btn-primary" form="storeTradeForm">Save</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
