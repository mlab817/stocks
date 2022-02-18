<div id="container" style="height: 100vh; min-width: 310px;"></div>

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

        // create the chart
        Highcharts.getJSON('{{ route('api.get_prices', $company->symbol) }}', function (data) {
            let ohlc = [],
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

            Highcharts.stockChart('container', {

                rangeSelector: {
                    selected: 0
                },

                plotOptions: {
                    macd: {
                        macdLine: {
                            styles: {
                                lineColor: '#0000ff'
                            }
                        },
                        signalLine: {
                            styles: {
                                lineColor: '#ff0000'
                            }
                        }
                    }
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
                },
                {
                    labels: {
                        align: 'right',
                        x: -3
                    },
                    title: {
                        text: 'MACD'
                    },
                    top: '55%',
                    bottom: '50%',
                    height: '35%',
                    offset: 0,
                    lineWidth: 2
                }
                ],

                tooltip: {
                    split: true
                },

                series: [{
                    type: 'candlestick',
                    id: '{{ $company->symbol }}',
                    name: '{{ $company->symbol }}',
                    data: ohlc,
                    dataGrouping: {
                        units: groupingUnits
                    },
                    upColor: '#52a39a',
                    color: '#dd5e56',
                },
                    // {
                    //     type: 'column',
                    //     name: 'Value',
                    //     data: value,
                    //     // yAxis: 0,
                    //     dataGrouping: {
                    //         units: groupingUnits
                    //     }
                    // },
                    {
                        type: 'line',
                        name: 'ALMA',
                        data: alma,
                        yAxis: 0,
                        dataGrouping: {
                            units: groupingUnits
                        },
                        color: '#fdec60'
                    },
                    {
                        type: 'macd',
                        linkedTo: '{{ $company->symbol }}',
                        yAxis: 1
                    }
                ],
            });
        });
    </script>
@endpush
