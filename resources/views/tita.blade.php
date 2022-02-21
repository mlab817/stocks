@extends('layouts.app')

@php
    $bullish = '<span class="text-success">(Bullish)</span>';
    $bearish = '<span class="text-danger">(Bearish)</span>';
@endphp

@section('content')
    <h2 class="h3 mt-2">TITA Status as of {{ \Carbon\Carbon::createFromFormat('Y-m-d', $latest_date)->format('M d, Y') }}</h2>

    <div class="card mb-5">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="data">
                    <thead>
                    <tr>
                        <th>Company</th>
                        <th class="text-center">Open</th>
                        <th class="text-center">High</th>
                        <th class="text-center">Low</th>
                        <th class="text-center">Close</th>
                        <th class="text-center">RSI</th>
                        <th class="text-center">ALMA</th>
                        <th class="text-center">ALMA Direction</th>
                        <th class="text-center">Value</th>
                        <th class="text-center">Risk (%)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($prices as $price)
                        <tr>
                            <td>
                                <a class="text-normal" target="_blank" href="{{ route('companies.show', $price->company) }}">
                                    {{ $price->company->symbol }}
                                </a>
                            </td>
                            <td class="text-center">
                                {{ number_format($price->open, 2) }}
                            </td>
                            <td class="text-center">
                                {{ number_format($price->high, 2) }}
                            </td>
                            <td class="text-center">
                                {{ number_format($price->low, 2) }}
                            </td>
                            <td class="text-center">
                                {{ number_format($price->close, 2) }}
                            </td>
                            <td class="text-center">
                                {{ number_format($price->rsi, 2) }}
                            </td>
                            <td class="text-center">
                                {{ number_format($price->alma, 2) }}
                            </td>
                            <td class="text-center">
                                {{ $price->alma_direction }}
                            </td>
                            <td class="text-right">
                                {{ number_format($price->value) }}
                            </td>
                            <td class="text-center">
                                {{ number_format($price->risk, 2) }}
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <p>
                This list shows stocks that meet the following criteria:
            </p>

            <ol>
                <li><strong>Bullish RSI:</strong> RSI is either 50 or 55.</li>
                <li><strong>Bullish ALMA:</strong> Lowest price is greater than ALMA.</li>
            </ol>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready( function () {
            $('#data').DataTable();
        });
    </script>
@endpush
