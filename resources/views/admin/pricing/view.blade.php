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
                                <dt>Departure City</dt>
                                <dd>{{ $pricing->departure_city }}</dd>

                                <dt>Airport of Departure City</dt>
                                <dd>{{ $pricing->departure_city_to_airport }}</dd>

                                <dt>Arrival City</dt>
                                <dd>{{ $pricing->arrival_city }}</dd>

                                <dt>Airport of Arrival City</dt>
                                <dd>{{ $pricing->arrival_city_to_airport }}</dd>

                                <dt>First Price</dt>
                                <dd>{{ number_format($pricing->price_first, 2, '.', ' ') }} &euro;</dd>

                                <dt>Second Price</dt>
                                <dd>{{ number_format($pricing->price_second, 2, '.', ' ') }} &euro;</dd>
                            </dl>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
    </div>
</div>
@endsection
