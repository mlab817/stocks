@extends('layouts.app')

@php
    $bullish = 'text-success';
    $bearish = 'text-danger';
@endphp

@section('content')
    <div class="container-lg">
        <h2 class="mt-2 mb-5">MAMA Status as of {{ \Carbon\Carbon::createFromTimestamp($prices->max('date'))->format('M d, Y') }}</h2>

        <div class="row mb-5">
            This list shows stocks that meet the following criteria:
            <ol>
                <li><strong>Bullish ALMA:</strong> Lowest price of the day is greater than ALMA.</li>
                <li><strong>Bullish MACD:</strong> MACD Line is greater than Signal Line. ()</li>
                <li><strong>Bullish volume:</strong> Value of trade is greater than P1 million</li>
                <li><strong>Tolerable risk:</strong> Risk (close price vs. ALMA) including fees of 1.195% is less than 5%.</li>
            </ol>

            <em>Note: This list does not capture when the MACD cross happened.</em>
        </div>

        <div class="row mb-5">
            <table class="table" id="data">
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
        </div>

        <div class="hovercard"></div>

        <!-- Compute trade -->
        <div class="row mt-6">
            <div class="card">
                <div class="card-body" x-data="{
                        cash: 20000,
                        price: 5,
                        get quantity() {
                            return this.price > 0
                                ? Math.floor(this.cash / this.price)
                                : 0
                        },
                        get gross_amount() {
                            return this.quantity * this.price
                        },
                        get buy() {
                            const ga = this.gross_amount
                            const commission = ga * 0.0025,
                                vat = ga * 0.0025 * 0.12,
                                sccp = ga * 0.0001,
                                pse = ga * 0.00005
                            const total = ga + commission + vat + sccp + pse
                            return {
                                commission: commission,
                                vat: vat,
                                sccp: sccp,
                                pse: pse,
                                total: total
                            }
                        },
                        get sell() {
                            const ga = this.gross_amount
                            const commission = ga * 0.0025,
                                vat = ga * 0.0025 * 0.12,
                                sccp = ga * 0.0001,
                                pse = ga * 0.00005,
                                sales = ga * 0.006

                            const total = ga + commission + vat + sccp + pse + sales
                            return {
                                commission: commission,
                                vat: vat,
                                sccp: sccp,
                                pse: pse,
                                sales: sales,
                                total: total
                            }
                        }
                    }">
                    <div class="row">
                        <label for="cash">Cash</label>
                        <input type="number" id="cash" name="cash" class="form-control" x-model="cash">

                        <label for="price">Price</label>
                        <input type="number" id="price" name="price" class="form-control" x-model="price">

                        <label for="quantity">No. of Shares</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" readonly x-model="quantity">
                    </div>
                    <div class="row">
                        <div class="col-6 p-3 text-center">
                            <h3>BUY</h3>

                            <form action="" class="form">
                                <label for="buy_gross_amount">Gross Amount</label>
                                <input type="number" class="form-control" x-model="gross_amount" readonly>
                                <label for="buy_commission">Broker's Commission</label>
                                <input type="number" class="form-control" name="buy_commission" id="buy_commission" readonly x-model="buy.commission">
                                <label for="buy_comm_vat">VAT on commission</label>
                                <input type="number" class="form-control" name="buy_comm_vat" id="buy_comm_vat" readonly x-model="buy.vat">
                                <label for="buy_sccp">SCCP</label>
                                <input type="number" class="form-control" name="buy_sccp" id="buy_sccp" readonly x-model="buy.sccp">
                                <label for="buy_pse">PSE Fee</label>
                                <input type="number" class="form-control" name="buy_pse" id="buy_pse" readonly x-model="buy.pse">
                                <label for="buy_total">Total</label>
                                <input type="number" class="form-control" name="buy_total" id="buy_total" readonly x-model="buy.total">
                            </form>
                        </div>
                        <div class="col-6 p-3 text-center">
                            <h3>SELL</h3>
                            <label for="buy_gross_amount">Gross Amount</label>
                            <input type="number" x-model="gross_amount" x-model="gross_amount">
                            <label for="sell_commission">Broker's Commission</label>
                            <input type="number" name="sell_commission" id="sell_commission" readonly x-model="sell.commission">
                            <label for="sell_comm_vat">VAT on commission</label>
                            <input type="number" name="sell_comm_vat" id="sell_comm_vat" readonly x-model="sell.vat">
                            <label for="sell_sccp">SCCP</label>
                            <input type="number" name="sell_sccp" id="sell_sccp" readonly x-model="sell.sccp">
                            <label for="sell_pse">PSE Fee</label>
                            <input type="number" name="sell_pse" id="sell_pse" readonly x-model="sell.pse">
                            <label for="sales_tax">Sales Tax</label>
                            <input type="number" name="sales_tax" id="sales_tax" readonly x-model="sell.sales">
                            <label for="sell_total">Total</label>
                            <input type="number" name="sell_total" id="sell_total" readonly x-model="sell.total">
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
