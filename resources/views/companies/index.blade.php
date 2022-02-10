@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('companies.index') }}" method="get">
            <div class="form-floating">
                <input type="search" value="{{ request()->query('search') }}" name="search" id="search" class="form-control" placeholder="Enter text to search...">
                <label for="search">Search</label>
            </div>
        </form>

        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Symbol</th>
                    <th>Listing Date</th>
                    <th>Sector</th>
                    <th>Subsector</th>
                    <th>Active</th>
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
                            {{ $company->active }}
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
