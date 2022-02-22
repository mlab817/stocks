@extends('layouts.app')

@php
    $bullish = '<span class="text-success">(Bullish)</span>';
    $bearish = '<span class="text-danger">(Bearish)</span>';
@endphp


@section('content')
    <h1 class="h3 mb-2 text-gray-800">Company Profile: {{ $company->symbol }}</h1>

    @include('chart', ['company' => $company])

    <h2 class="mt-5">Historical Price</h2>

    <p>Source: <a href="https://www.pse.com.ph">PSE</a>. Updated daily.</p>

    <div class="card">
        <div class="card-body" style="height: 50vh; overflow-y: scroll;">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: {{ 100/6 }}%;">Date</th>
                            <th style="width: {{ 100/6 }}%;">Open</th>
                            <th style="width: {{ 100/6 }}%;">High</th>
                            <th style="width: {{ 100/6 }}%;">Low</th>
                            <th style="width: {{ 100/6 }}%;">Close</th>
                            <th style="width: {{ 100/6 }}%;">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($prices->sortByDesc('date') as $price)
                        <tr>
                            <td>{{ \Carbon\Carbon::createFromTimestamp($price->date)->format('M d, Y') }}</td>
                            <td>{{ number_format($price->open, 2) }}</td>
                            <td>{{ number_format($price->high, 2) }}</td>
                            <td>{{ number_format($price->low, 2) }}</td>
                            <td>{{ number_format($price->close, 2) }}</td>
                            <td>{{ number_format($price->value, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
