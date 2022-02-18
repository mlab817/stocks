@extends('layouts.app')

@section('content')
    <div class="container-lg">
        @if($errors->any())
            <p>Please check the following for errors: </p>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <h3>Edit</h3>

        <form action="{{ route('trades.update', $trade) }}" method="POST" accept-charset="UTF-8">
            @csrf
            @method('PUT')
            <label for="trade_type" class="form-label mt-3 required">Buy or Sell</label>
            <select class="form-select" id="trade_type" name="trade_type">
                <option value="">Select One</option>
                @foreach($trade_types as $trade_type)
                    <option value="{{ $trade_type }}" @if(old('trade_type', $trade->trade_type) == $trade_type) selected @endif>
                        {{ strtoupper($trade_type) }}
                    </option>
                @endforeach
            </select>

            <label for="company_id" class="form-label mt-3 required">Stock</label>
            <select class="form-select" id="company_id" name="company_id">
                <option value="">Select One</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" @if(old('company_id', $trade->company_id) == $company->id) selected @endif>
                        {{ $company->symbol }}
                    </option>
                @endforeach
            </select>

            <label for="date" class="form-label mt-3 required">Date</label>
            <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $trade->date) }}">

            <label for="shares" class="form-label mt-3 required">No. of Shares</label>
            <input type="number" id="shares" name="shares" class="form-control" step="1" value="{{ old('shares', $trade->shares) }}">

            <label for="price" class="form-label mt-3 required">Price per Share</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" value="{{ old('price', $trade->price) }}">

            <label for="remarks" class="form-label mt-3">Remarks</label>
            <textarea name="remarks" id="remarks" class="form-control">{{ $trade->remarks }}</textarea>

            <button type="submit" class="btn btn-primary mt-3">Save</button>
        </form>
    </div>
@endsection