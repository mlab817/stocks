@extends('layouts.app')

@php
    $bullish = \App\Models\HistoricalPrice::BULLISH;
    $bearish = \App\Models\HistoricalPrice::BEARISH;
@endphp

@section('content')
    <h2 class="h3 mb-2 text-primary">MAMA Status as of {{ \Carbon\Carbon::createFromFormat('Y-m-d', $latestDate)->format('M d, Y') }}</h2>

    <div class="card mb-5">
        <div class="card-body">
            <div class="row">
                <form action="{{ route('mama') }}" method="get">

                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="data">
                    <thead>
                    <tr>
                        <th>Stock</th>
                        <th class="text-center">Open</th>
                        <th class="text-center">High</th>
                        <th class="text-center">Low</th>
                        <th class="text-center">Close</th>
                        <th class="text-center">ALMA</th>
                        <th class="text-center">Candle</th>
                        <th class="text-center">ALMA Direction</th>
                        <th class="text-center">MACD Direction</th>
                        <th class="text-center">Value</th>
                        <th class="text-center">
                            <span data-bs-toggle="tooltip" title="Risk is calculated as difference between closing price and ALMA plus 1.195% for fees">
                                Risk (%)
                            </span>
                        </th>
                        <th class="text-center">Recom</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($prices as $i => $price)
                        <tr>
                            <td>
                                <span rel="hovercard" data-url="/data" id="hovercard_{{$i}}">
                                    <a class="text-normal" target="_blank" href="{{ route('companies.show', $price->company) }}">
                                        {{ $price->company->symbol }}
                                    </a>
                                </span>
                            </td>
                            <td class="text-center">{{ number_format($price->open, 3) }}</td>
                            <td class="text-center">{{ number_format($price->high, 3) }}</td>
                            <td class="text-center">{{ number_format($price->low, 3) }}</td>
                            <td class="text-center">{{ number_format($price->close, 3) }}</td>
                            <td class="text-center">
                                {{ number_format($price->alma, 3) }}
                            </td>
                            <td class="text-center  @if($price->candle == $bullish) text-success @elseif($price->candle == $bearish) text-danger @endif">
                                {{ $price->candle }}
                            </td>
                            <td class="text-center @if($price->alma_direction == $bullish) text-success @elseif($price->alma_direction == $bearish) text-danger @endif">
{{--                                {{ number_format($price->alma, 2) }}--}}
                                {{ $price->alma_direction }}
                            </td>
                            <td class="text-center @if($price->macd_direction == $bullish) text-success @elseif($price->macd_direction == $bearish) text-danger @endif">
                                {{ $price->macd_direction }}
                            </td>
                            <td class="text-center @if($price->value > 10**6) text-success @else text-danger @endif">
                                {{ number_format($price->value, 0) }}
                            </td>
                            <td class="text-center @if($price->recommendation == \App\Models\HistoricalPrice::BUY && $price->risk < 5) text-success @else text-danger @endif">
                                {{ $price->recommendation == \App\Models\HistoricalPrice::BUY ? number_format($price->risk, 2) : '' }}
                            </td>
                            <td class="text-center">
                                {{ $price->recommendation }}
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

            <p>
                <ol>
                    <li><strong>Bullish ALMA:</strong> Lowest price of the day is greater than ALMA or ALMA crossed a bullish candle.</li>
                    <li><strong>Bullish MACD:</strong> MACD Line crossed Signal Line.</li>
                    <li><strong>Bullish volume:</strong> Value of trade is greater than P1 million</li>
                    <li><strong>Tolerable risk:</strong> Risk (last price vs. ALMA) including fees of 1.195% is less than 5%.</li>
                </ol>
            </p>
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
