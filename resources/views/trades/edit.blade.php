@extends('layouts.app')

@section('content')
    <h3 class="h3 mb-2">Edit Trade</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('trades.update', $trade) }}" method="POST" accept-charset="UTF-8">
                @csrf
                @method('PUT')
                <label for="trade_type" class="form-label mt-3 required">Buy or Sell</label>
                <select class="form-control @error('trade_type') is-invalid @enderror" id="trade_type" name="trade_type">
                    <option value="">Select One</option>
                    @foreach($trade_types as $trade_type)
                        <option value="{{ $trade_type }}" @if(old('trade_type', $trade->trade_type) == $trade_type) selected @endif>
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
                        <option value="{{ $company->id }}" @if(old('company_id', $trade->company_id) == $company->id) selected @endif>
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
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $trade->date) }}">

                <label for="shares" class="form-label mt-3 required">No. of Shares</label>
                <input type="number" id="shares" name="shares" class="form-control @error('shares') is-invalid @enderror" step="1" value="{{ old('shares', $trade->shares) }}">
                @error('shares')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
                @enderror

                <label for="price" class="form-label mt-3 required">Price per Share</label>
                <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" step="0.01" value="{{ old('price', $trade->price) }}">
                @error('price')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
                @enderror

                <label for="target_price" class="form-label mt-3 required">Target Price</label>
                <input type="number" id="target_price" name="target_price" class="form-control @error('target_price') is-invalid @enderror" step="0.01" value="{{ old('target_price', $trade->target_price) }}">
                @error('target_price')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
                @enderror

                <label for="cut_loss" class="form-label mt-3 required">Cut Loss Price</label>
                <input type="number" id="cut_loss" name="cut_loss" class="form-control @error('cut_loss') is-invalid @enderror" step="0.01" value="{{ old('cut_loss', $trade->cut_loss) }}">
                @error('cut_loss')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
                @enderror

                <label for="remarks" class="form-label mt-3">Remarks</label>
                <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror">{{ $trade->remarks }}</textarea>
                @error('remarks')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
                @enderror

                <div class="row mt-3 mx-1 align-items-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="ml-2" href="{{ route('trades.index') }}">Back to list</a>
                </div>

            </form>
        </div>
    </div>
@endsection
