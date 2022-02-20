@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Companies</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="data" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Symbol</th>
                            <th>Listing Date</th>
                            <th>Sector</th>
                            <th>Subsector</th>
                            <th>Last Traded Date</th>
                            <th>Last Price</th>
                            <th>% Change</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($companies as $company)
                        <tr @if(! $company->active) class="table-danger" @endif>
                            <td>
                                {{ $company->name }}
                            </td>
                            <td>
                                <a href="{{ route('companies.show', $company) }}">
                                    {{ $company->symbol }}
                                </a>
                            </td>
                            <td>
                                {{ $company->listing_date }}
                            </td>
                            <td>
                                {{ $company->subsector->sector->label }}
                            </td>
                            <td>
                                {{ $company->subsector->label }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::createFromTimestamp($company->last_traded_date)->format('M d, Y') }}
                            </td>
                            <td class="text-right">
                                {{ number_format(optional($company->latest_price)->close, 2) }}
                            </td>
                            <td @if(optional($company->latest_price)->pct_change > 0) class="text-right text-success" @else class="text-right text-danger" @endif>
                                {{ number_format(optional($company->latest_price)->pct_change, 2) }}
                            </td>
                            <td class="text-nowrap">
                                <div class="d-flex">
                                    <a href="{{ route('companies.edit', $company) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pen-fill"></i>
                                    </a>

                                    @if(auth()->user()->watchlists()->where('company_id', $company->id)->exists())
                                        <a href="#" class="btn btn-danger btn-sm ml-1" data-toggle="modal" data-target="#removeFromWatchlist_{{$company->id}}">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </a>

                                        <!-- Logout Modal-->
                                        <div class="modal fade" id="removeFromWatchlist_{{$company->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <form onsubmit="return confirm('Remove this stock to your watchlist?');" action="{{ route('watchlists.destroy') }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Remove from Watchlist</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="{{ $company->id }}">
                                                            Are you sure you want to remove this from watchlist?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <a href="#" class="btn btn-success btn-sm ml-1" data-toggle="modal" data-target="#addToWatchlist_{{$company->id}}">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        <!-- Logout Modal-->
                                        <div class="modal fade" id="addToWatchlist_{{$company->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <form onsubmit="return confirm('Add this stock to your watchlist?');" action="{{ route('watchlists.store') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Add to Watchlist</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="{{ $company->id }}">
                                                            <label for="remarks">Remarks</label>
                                                            <textarea name="remarks" id="remarks" class="form-control" rows="5" style="resize: none;"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
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
