@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.airports.index') }}">Airports</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $airport->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>View Airport</h3>

                    <div class="card">
                        <div class="card-body">

                            <dl class="mb-0">
                                <dt>Name</dt>
                                <dd>{{ $airport->name }}</dd>

                                <dt>City</dt>
                                <dd>{{ $airport->city }}</dd>

                                <dt>Country</dt>
                                <dd>{{ $country->name }}</dd>
                                
                                <dt>IATA</dt>
                                <dd>{{ $airport->iata }}</dd>

                                <dt>ICAO</dt>
                                <dd>{{ $airport->icao }}</dd>

                                <dt>Latitude</dt>
                                <dd>{{ $airport->latitude }}</dd>

                                <dt>Longitude</dt>
                                <dd>{{ $airport->longitude }}</dd>

                                <dt>Timezone</dt>
                                <dd class="mb-0">
                                    {{ $airport->timezone }}
                                </dd>
                            </dl>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
    </div>
</div>
@endsection
