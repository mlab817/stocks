@extends('layouts.app')

@section('content')
    <h3 class="h3 mb-2">Prices</h3>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-title">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Portfolio
                    </h6>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
        @auth
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Watch List
                    </h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group border-0">
                        @foreach($watchlists as $wl)
                        <li class="list-group-item">
                            <div class="d-flex">
                                <a href="{{ route('companies.show', $wl->company) }}">
                                    {{ $wl->company->symbol }}
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endauth
    </div>

@endsection
