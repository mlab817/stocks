@extends('layouts.app')

@php
    $bullish = '<span class="text-success">(Bullish)</span>';
    $bearish = '<span class="text-danger">(Bearish)</span>';
@endphp

@section('content')
    <div class="container-lg">
        <h2 class="mt-2 mb-5">BOPIS Status as of {{ \Carbon\Carbon::createFromTimestamp($prices->max('date'))->format('M d, Y') }}</h2>

        <div class="mb-5">
            This list shows stocks that meet the following criteria:
            <ol>
                <li><strong>Bullish Parabolic SAR:</strong> Lowest price of the day is greater than Parabolic SAR.</li>
                <li><strong>Bullish EMA 9:</strong> Lowest price is greater than EMA (9).</li>
                <li><strong>Bullish TRIX:</strong> TRIX about to cross 0 or above 0.</li>
            </ol>
        </div>

        <table class="table mt-5" id="data">
            <thead>
            <tr>
                <th>Stock</th>
                <th class="text-center">Open</th>
                <th class="text-center">High</th>
                <th class="text-center">Low</th>
                <th class="text-center">Close</th>
                <th class="text-center">TRIX</th>
                <th class="text-center">Parabolic SAR</th>
                <th class="text-center">EMA (9)</th>
                <th class="text-center">Value</th>
                <th class="text-center">Risk (%)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($prices as $i => $price)
                <tr>
                    <td>
                        <a class="text-normal" target="_blank" href="{{ route('companies.show', $price->company) }}">
                            {{ $price->company->symbol }}
                        </a>
                    </td>
                    <td class="text-center">{{ $price->open }}</td>
                    <td class="text-center">{{ $price->high }}</td>
                    <td class="text-center">{{ $price->low }}</td>
                    <td class="text-center">{{ $price->close }}</td>
                    <td class="text-center">{{ $price->psar }} <br/>
                        {!! $price->low > $price->psar ? $bullish : $bearish !!}
                    </td>
                    <td class="text-center">{{ $price->low }} <br/>
                        {!! $price->low > $price->ema_9 ? $bullish : $bearish !!}
                    </td>
                    <td class="text-center">
                        {{ $price->trix }} <br/>
                        {!!
                           abs($price->trix) >= 0.1 ? $bullish : $bearish
                        !!}
                    </td>
                    <td class="text-center">
                        {!! $price->value > 10**6 ? $bullish : $bearish !!}  <br/>
                        {{ number_format($price->value,0) }} </td>
                    <td class="text-center">
                        {!! $price->risk == '-' ? '' : (floatval($price->risk) <= 5 && floatval($price->risk) > 0 ? $bullish : $bearish) !!} <br/>
                        {{ $price->risk }} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="//code.jquery.com/jquery-3.5.1.js"></script>
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready( function () {
            $('#data').DataTable();
        });
    </script>
@endpush
