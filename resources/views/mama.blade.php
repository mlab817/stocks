@extends('layouts.app')

@php
    $bullish = 'text-success';
    $bearish = 'text-danger';
@endphp

@section('content')
    <div class="container-lg">
        <h2 class="mt-2 mb-5">MAMA Status as of {{ \Carbon\Carbon::createFromTimestamp($prices->max('date'))->format('M d, Y') }}</h2>

        <div class="mb-5">
            This list shows stocks that meet the following criteria:
            <ol>
                <li><strong>Bullish ALMA:</strong> Lowest price of the day is greater than ALMA.</li>
                <li><strong>Bullish MACD:</strong> MACD Line is greater than Signal Line. ()</li>
                <li><strong>Bullish volume:</strong> Value of trade is greater than P1 million</li>
                <li><strong>Tolerable risk:</strong> Risk (close price vs. ALMA) including fees of 1.195% is less than 5%.</li>
            </ol>

            <em>Note: This list does not capture when the MACD cross happened.</em>
        </div>

        <table class="table mt-5" id="data">
            <thead>
                <tr>
                    <th>Company</th>
                    <th class="text-center">Open</th>
                    <th class="text-center">High</th>
                    <th class="text-center">Low</th>
                    <th class="text-center">Close</th>
                    <th class="text-center">ALMA</th>
                    <th class="text-center">MACD Hist</th>
                    <th class="text-center">Value</th>
                    <th class="text-center">
                        <span data-bs-toggle="tooltip" title="Risk is calculated as difference between closing price and ALMA plus 1.195% for fees">
                            Risk (%)
                        </span>
                    </th>
                    <th class="text-center">Action</th>
                    <th class="text-center">Remark</th>
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
                        <td class="text-center">{{ $price->open }}</td>
                        <td class="text-center">{{ $price->high }}</td>
                        <td class="text-center">{{ $price->low }}</td>
                        <td class="text-center">{{ $price->close }}</td>
                        <td class="text-center @if($price->low > $price->alma) text-success @else text-danger @endif">
                            {{ number_format($price->alma, 2) }}
                        </td>
                        <td class="text-center @if($price->macd_hist >= 0) text-success @else text-danger @endif">
                            {{ number_format($price->macd_hist, 2) }}
                        </td>
                        <td class="text-center @if($price->value_bullish) text-success @else text-danger @endif">
                            {{ number_format($price->value, 0) }}
                        </td>
                        <td class="text-center @if($price->risk < 5) text-success @else text-danger @endif">
                            {{ $price->risk }}
                        </td>
                        <td class="text-center">
                            {!! $price->mama
                                ? '<span class="badge rounded-pill bg-success">buy</span>'
                                : '<span class="badge rounded-pill bg-secondary">watch</span>' !!}
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="hovercard"></div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="//code.jquery.com/jquery-3.5.1.js"></script>
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready( function () {
            $('#data').DataTable();

            $('span[rel="hovercard"]').hover(
                function(e) {
                    const id = $(this).attr('id')
                    const position = $(`#${id}`).offset();

                    const x = $(this).data('url');
                    // $.getJSON('hover_data.json', function (data) {
                    //     $('.hovercard').html('<h3>'+eval('data.'+x+'.full_name')+'</h3>Place : '+eval('data.'+x+'.place')+'<br/><a href="'+eval('data.'+x+'.facebook')+'">'+eval('data.'+x+'.facebook')+'</a>')
                    // })
                    $('.hovercard').html('<h3>Info card</h3>')
                    $('.hovercard').show().css('top', position.top + 40).css('left', position.left);
                    //Mouse In code
                },
                function(e){
                    $('.hovercard').hide();
                    //Mouse Out code
                    $('.hovercard').html('');
                }
            );
        });
    </script>
@endpush
