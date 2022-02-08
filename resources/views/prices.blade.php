@extends('layouts.app')

@php
    $bullish = '<span class="text-success">(Bullish)</span>';
    $bearish = '<span class="text-danger">(Bearish)</span>';
@endphp

@section('content')
    <div class="container-lg">
        <table class="table">
            <thead>
                <tr>
                    <th>Company</th>
                    <th class="text-center">Open</th>
                    <th class="text-center">High</th>
                    <th class="text-center">Low</th>
                    <th class="text-center">Close</th>
                    <th class="text-center">Value</th>
                    <th class="text-center">Risk (%)</th>
                    <th class="text-center">ALMA</th>
                    <th class="text-center">MACD Hist</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prices as $price)
                    <tr>
                        <td>
                            <a class="text-no" href="{{ route('companies.historical_prices.index', $price->company) }}">
                                {{ $price->company->symbol }}
                            </a>
                        </td>
                        <td class="text-center">{{ $price->open }}</td>
                        <td class="text-center">{{ $price->high }}</td>
                        <td class="text-center">{{ $price->low }}</td>
                        <td class="text-center">{{ $price->close }}</td>
                        <td class="text-center">{{ number_format($price->value,0) }} <br/> {!! $price->value > 10**6 ? $bullish : $bearish !!} </td>
                        <td class="text-center">{{ $price->risk }}</td>
                        <td class="text-center">{{ $price->alma }} <br/>
                            {!! $price->low > $price->alma ? $bullish : $bearish !!}
                        </td>
                        <td class="text-center">{{ $price->macd_hist }} <br/>
                            {!! $price->macd_hist > 0 ? $bullish : $bearish !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
