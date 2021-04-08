@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.pricing.index') }}">Pricing</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $pricing->departure_city }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>View Airline</h3>

                    <div class="card">
                        <div class="card-body">

                            <dl class="mb-0">
                                <dt>Departure Airport</dt>
                                <dd>{{ $pricing->departure }}</dd>

                                <dt>Arrival Airport</dt>
                                <dd>{{ $pricing->arrival }}</dd>

                                <dt>Time</dt>
                                <dd>{{ $pricing->time }}</dd>

                                <dt>Price Turbo</dt>
                                <dd>{{ number_format($pricing->price_turbo, 2, '.', ' ') }} &dollar;</dd>

                                <dt>Price Light</dt>
                                <dd>{{ number_format($pricing->price_light, 2, '.', ' ') }} &dollar;</dd>
                                
                                <dt>Price Medium</dt>
                                <dd>{{ number_format($pricing->price_medium, 2, '.', ' ') }} &dollar;</dd>

                                <dt>Price Heavy</dt>
                                <dd>{{ number_format($pricing->price_heavy, 2, '.', ' ') }} &dollar;</dd>
                            </dl>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
    </div>
</div>
@endsection
