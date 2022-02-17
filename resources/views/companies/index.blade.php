@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Companies</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
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
                        <th>Last Price</th>
                        <th>% Change</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($companies as $company)
                        <tr>
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
                                {{ number_format(optional($company->latest_price)->close, 2) }}
                            </td>
                            <td @if(optional($company->latest_price)->pct_change > 0) class="text-success" @else class="text-danger" @endif>
                                {{ number_format(optional($company->latest_price)->pct_change, 2) }}
                            </td>
                            <td>
                                <a href="{{ route('companies.edit', $company) }}" class="btn btn-primary">Edit</a>
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
