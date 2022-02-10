@extends('layouts.app')

@php
    $bullish = '<span class="text-success">(Bullish)</span>';
    $bearish = '<span class="text-danger">(Bearish)</span>';
@endphp


@section('content')
    <div class="container-lg mb-5">
        <div id="container" style="height: 100vh; min-width: 310px;"></div>
    </div>

    <div class="container-lg">
        <h2>Historical Price</h2>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Open</th>
                <th>High</th>
                <th>Low</th>
                <th>Close</th>
                <th>Value</th>
                <th>ALMA</th>
                <th>MACD Hist</th>
                <th>MAMA</th>
                <th>Action</th>
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
                    <td>{{ number_format($price->alma, 2)}} <br/>
                        {!! is_null($price->alma) ? '' : ($price->low > $price->alma ? $bullish : $bearish) !!}</td>
                    <td>{{ number_format($price->macd_hist, 2) }} <br/> {!! is_null($price->macd_hist) ? '' : ($price->macd_hist > 0 ? $bullish : $bearish) !!}</td>
                    <td>{!! (!is_null($price->alma) && $price->low > $price->alma && $price->macd_hist > 0) ? $bullish : $bearish  !!}</td>
                    <td>
                        <form action="{{ route('historical_prices.destroy', $price) }}" method="POST">
                            @method('delete')
                            @csrf
                            <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/modules/data.js"></script>
    <script src="https://code.highcharts.com/stock/modules/drag-panes.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>

    <script src="https://code.highcharts.com/stock/indicators/indicators-all.js"></script>

    <script src="https://code.highcharts.com/modules/annotations-advanced.js"></script>
    <script src="https://code.highcharts.com/modules/price-indicator.js"></script>
    <script src="https://code.highcharts.com/modules/full-screen.js"></script>

    <script src="https://code.highcharts.com/modules/stock-tools.js"></script>

    <script src="https://code.highcharts.com/stock/modules/heikinashi.js"></script>
    <script src="https://code.highcharts.com/stock/modules/hollowcandlestick.js"></script>

    <script>
        const data = @json($company->prices()->orderBy('date','asc')->get())

        // Highcharts.getJSON('https://demo-live-data.highcharts.com/aapl-ohlcv.json', function (data) {

            // split the data set into ohlc and volume
            var ohlc = [],
                value = [],
                alma = [],
                dataLength = data.length,
                // set the allowed units for data grouping
                groupingUnits = [[
                    'week',                         // unit name
                    [1]                             // allowed multiples
                ], [
                    'month',
                    [1, 2, 3, 4, 6]
                ]],

                i = 0;

            for (i; i < dataLength; i += 1) {
                alma.push([
                    data[i].date * 1000, // the date
                    data[i].alma, // open
                ])

                ohlc.push([
                    data[i].date * 1000, // the date
                    data[i].open, // open
                    data[i].high, // high
                    data[i].low, // low
                    data[i].close // close
                ]);

                value.push([
                    data[i].date * 1000, // the date
                    data[i].value // the volume
                ]);
            }

            // create the chart
            Highcharts.stockChart('container', {

                rangeSelector: {
                    selected: 1
                },

                title: {
                    text: '{{ $company->name }}'
                },

                yAxis: [{
                    labels: {
                        align: 'right',
                        x: -3
                    },
                    title: {
                        text: 'OHLC'
                    },
                    height: '60%',
                    lineWidth: 2,
                    resize: {
                        enabled: true
                    }
                }, {
                    labels: {
                        align: 'right',
                        x: -3
                    },
                    title: {
                        text: 'Volume'
                    },
                    top: '65%',
                    height: '35%',
                    offset: 0,
                    lineWidth: 2
                }],

                tooltip: {
                    split: true
                },

                series: [{
                    type: 'candlestick',
                    name: '{{ $company->symbol }}',
                    data: ohlc,
                    dataGrouping: {
                        units: groupingUnits
                    },
                    upColor: '#52a39a',
                    color: '#dd5e56',
                }, {
                    type: 'column',
                    name: 'Value',
                    data: value,
                    yAxis: 1,
                    dataGrouping: {
                        units: groupingUnits
                    }
                }, {
                    type: 'line',
                    name: 'ALMA',
                    data: alma,
                    yAxis: 0,
                    dataGrouping: {
                        units: groupingUnits
                    },
                    color: '#fdec60'
                }],
            });
        // });
    </script>
@endpush
