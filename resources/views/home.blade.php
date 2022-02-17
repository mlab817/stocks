@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h3>Prices</h3>
    </div>

    <div class="row">
        @foreach($companies as $company)
            @php($change = optional($company->latest_price)->pct_change)
            <div class="col-2 p-2">
                <div class="card text-white bg-gradient">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4>
                                {{ $company->symbol }}
                            </h4>
                            {{ number_format(optional($company->latest_price)->pct_change, 2) }}%
                        </div>
                        <div class="d-flex text-end">
                            <span class="w-100"></span>
                            <h5>
                                {{ number_format(optional($company->latest_price)->close, 2) }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
