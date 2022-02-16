@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-responsive" id="data">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Symbol</th>
                    <th>Listing Date</th>
                    <th>Sector</th>
                    <th>Subsector</th>
                    <th>Last Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                    <tr @if(!$company->active) class="table-danger" @endif>
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
                        <td>
                            <a href="{{ route('companies.edit', $company) }}" class="btn btn-primary">Edit</a>
                        </td>
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
