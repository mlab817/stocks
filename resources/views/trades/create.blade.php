@extends('layouts.app')

@section('content')
    <h3 class="h3 mb-2">Add Trade</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('trades.store') }}" method="POST" accept-charset="UTF-8" class="mb-5">
                @csrf
                <label for="trade_type" class="form-label mt-3 required">Buy or Sell</label>
                <select class="form-control @error('trade_type') is-invalid @enderror" id="trade_type" name="trade_type">
                    <option value="">Select One</option>
                    @foreach($trade_types as $trade_type)
                        <option value="{{ $trade_type }}">
                            {{ strtoupper($trade_type) }}
                        </option>
                    @endforeach
                </select>
                @error('trade_type')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
                @enderror

                <label for="company_id" class="form-label mt-3 required">Stock</label>
                <select class="form-control @error('company_id') is-invalid @enderror" id="company_id" name="company_id">
                    <option value="">Select One</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">
                            {{ $company->symbol }}
                        </option>
                    @endforeach
                </select>
                @error('company_id')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
                @enderror

                <label for="date" class="form-label mt-3 required">Date</label>
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror">
                @error('date')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
                @enderror

                <label for="shares" class="form-label mt-3 required">No. of Shares</label>
                <input type="number" id="shares" name="shares" class="form-control @error('shares') is-invalid @enderror" step="1">
                @error('shares')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
                @enderror

                <label for="price" class="form-label mt-3 required">Price per Share</label>
                <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" step="0.01">
                @error('price')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
                @enderror

                <label for="remarks" class="form-label mt-3">Remarks</label>
                <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror"></textarea>
                @error('remarks')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
                @enderror

                <div class="row align-items-center mx-1 mt-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="ml-2" href="{{ route('trades.index') }}">Back to list</a>
                </div>
            </form>
        </div>
    </div>
@endsection
