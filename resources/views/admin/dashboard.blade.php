@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="mb-3">Dashboard</h3>
            <div class="card-columns">
                <div class="card bg-dark text-white text-center">
                    <div class="card-body">
                        <h1 class="card-text mb-0">{{ $searchesCount }}</h1>
                        <p class="card-text text-muted">searches</p>
                    </div>
                </div>

                <div class="card bg-dark text-white text-center">
                    <div class="card-body">
                        <h1 class="card-text mb-0">{{ $usersCount }}</h1>
                        <p class="card-text text-muted">clients</p>
                    </div>
                </div>

                <div class="card bg-dark text-white text-center">
                    <div class="card-body">
                        <h1 class="card-text mb-0">{{ number_format($earningsAmount, 2, '.', ' ') }} &euro;</h1>
                        <p class="card-text text-muted">earnings</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
