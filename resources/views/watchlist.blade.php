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
                            <th></th>
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
                                <td>
                                    <form onsubmit="return confirm('Are you sure you want to remove this from watchlist?')" class="form-inline" action="{{ route('watchlists.destroy') }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id" value="{{ $watchlist->id }}">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
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
