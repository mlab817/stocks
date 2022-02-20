@extends('layouts.app')

@section('content')
    <h3 class="h3 mb-2">Watchlist</h3>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Symbol</th>
                            <th>Last Traded Date</th>
                            <th>Last Price</th>
                            <th>% Change</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($watchlists as $watchlist)
                            <tr>
                                <td>
                                    <a href="{{ route('companies.show', $watchlist->company) }}" target="_blank">
                                        {{ $watchlist->company->symbol }}
                                    </a>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::createFromTimestamp($watchlist->company->latest_price->date)->format('M d, Y') }}
                                </td>
                                <td>
                                    {{ $watchlist->company->latest_price->close }}
                                </td>
                                <td>
                                    {{ $watchlist->company->latest_price->pct_change }}
                                </td>
                                <td>
                                    {{ $watchlist->remarks }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">No stock in the watch list</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
