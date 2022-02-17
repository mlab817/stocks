@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Trading Calculator</h1>

    <div class="row my-5" x-data="{
        price: 10,
        quantity: 800,
        get breakeven() {
            const quantity = this.quantity, price = this.price
            const acqPrice = this.buy.total ?? 0

            if (acqPrice >= 8000) {
                return (quantity > 0 ? acqPrice / 0.99105 / quantity : 0).toFixed(2)
            } else {
                const fixedFee = 22.4
                const net = acqPrice + fixedFee
                const pct = 0.006 + 0.0001 + 0.00005

                return quantity > 0 ? ( net / (1 - pct) / quantity) : 0
            }
        },
        get buy() {
            const price = this.price, quantity = this.quantity
            const gross = price * quantity
            const commission = gross < 8000 ? 20 : gross * 0.0025
            const vat = commission * 0.12
            const sccp = gross * 0.0001
            const pse = gross * 0.00005
            const transactionFee = commission + vat + sccp + pse
            const total = gross + transactionFee
            const averageCost = quantity > 0 ? total / quantity : 0

            return {
                gross: gross,
                commission: commission,
                vat: vat,
                sccp: sccp,
                pse: pse,
                transactionFee: transactionFee,
                total: total,
                averageCost: averageCost
            }
        }
    }">
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr class="table-success">
                        <th colspan="2" class="text-center">BUY</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Quantity</td>
                        <td>
                            <input type="text" class="form-control text-right" x-model="quantity">
                        </td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td>
                            <input type="text" class="form-control text-right" x-model="price">
                        </td>
                    </tr>
                    <tr>
                        <td>Buy Gross</td>
                        <td class="text-right">
                            <span x-text="buy.gross.toLocaleString('en-US')"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Buy Commission</td>
                        <td class="text-right">
                            <span x-text="buy.commission.toLocaleString('en-US')"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>VAT</td>
                        <td class="text-right">
                            <span x-text="buy.vat.toLocaleString('en-US')"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>SCCP</td>
                        <td class="text-right">
                            <span x-text="buy.sccp.toLocaleString('en-US')"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>PSE</td>
                        <td class="text-right">
                            <span x-text="buy.pse.toLocaleString('en-US')"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Transaction Fee</td>
                        <td class="text-right">
                            <span x-text="buy.transactionFee.toLocaleString('en-US')"></span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Total Charges</td>
                        <td class="text-right">
                            <span x-text="buy.total.toLocaleString('en-US')"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Average Cost</td>
                        <td class="text-right">
                            <span x-text="buy.averageCost.toLocaleString('en-US')"></span>
                        </td>
                    </tr>
                    <tr>
                        <th>Breakeven Price</th>
                        <th class="text-right">
                            <span x-text="breakeven.toLocaleString('en-US')"></span>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sell At</th>
                        <th>Net Profit</th>
                        <th>% Profit</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
