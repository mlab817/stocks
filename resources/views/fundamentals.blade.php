@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Fundamental Analysis</h1>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="data">
                    <thead>
                        <tr>
                            <th>Security</th>
                            <th>Sector</th>
                            <th>Outstanding Shares</th>
                            <th>Free-float Shares</th>
                            <th>Last Traded Volume</th>
                            <th>% Last Traded</th>
                            <th>Last Trading Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td>
                                    <a href="{{ route('companies.show', $company) }}">
                                    {{ $company->symbol }}
                                    </a>
                                </td>
                                <td>{{ optional($company->subsector)->sector->label }}</td>
                                <td>{{ number_format($company->outstanding_shares, 0) }}</td>
                                <td>{{ number_format($company->traded_shares, 0) }}</td>
                                <td>{{ number_format($company->latest_volume, 0) }}</td>
                                <td>
                                    {{ number_format($company->pct_traded, 2) }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::createFromTimestamp($company->last_traded_date)->format('M d, Y') }}
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
        $('#data').DataTable();
    </script>
@endpush
