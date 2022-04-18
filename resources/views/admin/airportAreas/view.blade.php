@extends('admin.layouts.app')

@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.airportAreas.index') }}">{{__('Areas Airports')}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $airportArea['cityName'] }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>{{__('View Area')}}</h3>
                    <div class="card">
                        <div class="card-body">

                            <dl class="mb-0">
                                <dt>{{__('Area')}}</dt>
                                <dd>{{ $airportArea['cityName'] }} {{ $airportArea['regionName'] }} {{ $airportArea['countryName'] }}</dd>

                                <dt>{{__('Airport Basic')}} ({{ $airportArea['cityAirportCount'] }})</dt>
                                @forelse ($airportArea['cityAirport'] as $value)
                                    <dd>{{ $value->icao }}/{{ $value->iata }} {{ $value->name }} </dd>
                                @empty
                                    <p>No city Airport</p>
                                @endforelse

                                <dt>{{__('Airport Additional')}} ({{ $airportArea['areaAirportCount'] }})</dt>
                                @forelse ($airportArea['areaAirport'] as $value)
                                    @foreach($value->airport as $val)
                                        <dd>{{ $val->icao }}/{{ $val->iata }} {{ $val->name }} ({{ $val->cities->name }}) </dd>
                                    @endforeach
                                @empty
                                    <p>No area Airport</p>
                                @endforelse

                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
