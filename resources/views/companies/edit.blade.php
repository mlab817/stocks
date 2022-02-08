@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('companies.update', $company) }}" method="POST" accept-charset="UTF-8">
            @csrf
            @method('PUT')
            <label for="name" class="form-label mt-3 required">Name</label>
            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $company->name) }}">

            <label for="symbol" class="form-label mt-3 required">Symbol</label>
            <input class="form-control" type="text" name="symbol" id="symbol" value="{{ old('symbol', $company->symbol) }}">

            <label for="listing_date" class="form-label mt-3 required">Listing Date</label>
            <input class="form-control" type="date" name="listing_date" id="listing_date" value="{{ old('listing_date', $company->listing_date) }}">

            <div class="form-check mt-3">
                <input type="checkbox" name="psei" id="psei" class="form-check-input" value="1" @if($company->psei) checked @endif>
                <label for="psei" class="form-check-label">Included in the PSE index</label>
            </div>

            <div class="form-check mt-3">
                <input type="checkbox" name="active" id="active" class="form-check-input" value="1" @if($company->active) checked @endif>
                <label for="active" class="form-check-label">Is active?</label>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save</button>
        </form>
    </div>
@endsection
