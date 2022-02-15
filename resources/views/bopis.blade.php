@extends('layouts.app')

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
                <th>ID</th>
                <th>Company</th>
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
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <a class="text-normal" target="_blank" href="{{ route('companies.show', $price->company) }}">
                            {{ $price->company->symbol }}
                        </a>
                    </td>
                    <td class="text-center">{{ $price->open }}</td>
                    <td class="text-center">{{ $price->high }}</td>
                    <td class="text-center">{{ $price->low }}</td>
                    <td class="text-center">{{ $price->close }}</td>
                    <td class="text-center">{{ $price->alma }} <br/>
                        {!! $price->low > $price->alma ? $bullish : $bearish !!}
                    </td>
                    <td class="text-center">{{ $price->macd_hist }} <br/>
                        {!! $price->macd_hist > 0 ? $bullish : $bearish !!}
                    </td>
                    <td class="text-center">
                        {!!
                            $price->low > $price->alma
                            && $price->macd_hist > 0 ? $bullish : $bearish
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
