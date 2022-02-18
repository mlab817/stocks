@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Trading Calculator</h1>

    <div class="card">
        <div class="card-body">
            <div class="row" x-data="{
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
            },
            get board_and_increment() {
                const price = this.price
                switch (true) {
                    case price >= 0.0001 && price <= 0.0099:
                        return [10**6, 0.0001]
                    case price >= 0.010 && price <= 0.049:
                        return [10**5, 0.001]
                    case price >= 0.05 && price <= 0.249:
                        return [10**4, 0.001]
                    case price >= 0.25 && price <= 0.495:
                        return [10**4, 0.005]
                    case price >= 0.5 &&  price <= 4.99:
                        return [10**3, 0.01]
                    case price >= 5 && price <= 9.99:
                        return [10**2, 0.01]
                    case price >= 10 && price <= 19.98:
                        return [10**2, 0.02]
                    case price >= 20 && price <= 49.95:
                        return [10**2, 0.05]
                    case price >= 50 && price <= 99.95:
                        return [10, 0.05]
                    case price >= 100 && price <= 199:
                        return [10, 0.10]
                    case price >= 200 && price <= 499.80:
                        return [10, 0.20]
                    case price >= 500 && price <= 999.50:
                        return [10, 0.50]
                    case price >= 1000 && price <= 1999:
                        return [5, 1]
                    case price >= 2000 && price <= 4998:
                        return [5, 2]
                    case price >= 5000:
                        return [5, 5]
                    default:
                        return [0, 0]
                }
            },
            get prices() {
                const incs = [1,2,3,4,5,6,7,8,9,10],
                    price = parseFloat(this.price)
                    fluctuations = this.board_and_increment[1]
                return incs.map(inc => {
                        const newPrice = price + inc * 2 * fluctuations,
                            profit = this.calculateProfit(newPrice)
                        return {
                            newPrice: newPrice,
                            profit: profit.profit,
                            pct_profit: profit.pct_profit
                        }
                    })
            },
            calculateProfit(price) {
                console.log(price)
                const acquisitionCost = this.buy.total,
                    grossAmount = this.quantity * price

                const net = grossAmount >= 8000
                    ? grossAmount - (0.00895 * grossAmount)
                    : grossAmount - 22.40 - (0.00615 * grossAmount)

                const profit = net - acquisitionCost

                return {
                    profit: (profit).toFixed(2),
                    pct_profit: (acquisitionCost > 0 ? profit / acquisitionCost * 100 : 0).toFixed(2)
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
                            <td>Quantity (No. of Shares)</td>
                            <td>
                                <input type="text" class="form-control text-right" x-model="quantity">
                            </td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td class="text-right">
                                <input type="text" class="form-control text-right" x-model="price">
                            </td>
                        </tr>
                        <tr>
                            <td>Board Lot / Price Fluctuations</td>
                            <td class="text-right">
                                <span x-text="board_and_increment[0]"></span> /
                                <span x-text="board_and_increment[1]"></span>
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
                            <tr class="table-danger">
                                <th class="text-center">Sell At</th>
                                <th class="text-center">Net Profit</th>
                                <th class="text-center">% Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                        <template x-for="({ newPrice, profit, pct_profit }, index) in prices" :key="index">
                            <tr>
                                <td class="text-center">
                                    <span x-text="newPrice && newPrice.toFixed(2)"></span>
                                </td>
                                <td class="text-center" x-bind:class="profit >= 0 ? 'text-success' : 'text-danger'">
                                    <span x-text="profit"></span>
                                </td>
                                <td class="text-center" x-bind:class="profit >= 0 ? 'text-success' : 'text-danger'">
                                    <span x-text="pct_profit"></span>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
