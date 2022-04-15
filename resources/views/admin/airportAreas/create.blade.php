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
                    <li class="breadcrumb-item active" aria-current="page">{{__('Create')}}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>{{__('New Area Airports')}}</h5>
                    <h6 class="card-subtitle mb-3 text-muted">{{__('Fill the details of a new Area Airports')}}</h6>

                    <form method="POST" action="{{ route('admin.airportAreas.store') }}" id="quickForm">
                        @csrf
                        @method('PUT')

                        <div class="form-group" id="city-select2">
                            <label for="city">{{__('New Area')}}*</label>
                            <select name="city" id="city" class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}" required>

                            </select>

                            @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group" id="cityAirport-select2">
                            <label for="cityAirport">{{__('Airports for Area')}}*</label>
                            <select name="cityAirport[]" id="cityAirport" class="form-control {{ $errors->has('cityAirport') ? ' is-invalid' : '' }}" multiple required disabled>

                            </select>

                            @if ($errors->has('cityAirport'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('cityAirport') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group" id="areaAirport-select2">
                            <label for="areaAirport">{{__('Airports for Area')}}*</label>
                            <select name="areaAirport[]" multiple id="areaAirport" class="form-control {{ $errors->has('areaAirport') ? ' is-invalid' : '' }}" required>

                            </select>

                            @if ($errors->has('areaAirport'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('areaAirport') }}</strong>
                                </span>
                            @endif
                        </div>
{{--
                        <div class="form-group" id="cityAirport-select2">
                            <label for="cityAirport">{{__('City Airport')}}*</label>
                            <select name="cityAirport[]" id="cityAirport" class="form-control{{ $errors->has('cityAirport') ? ' is-invalid' : '' }}" multiple required disabled>
                                @forelse ($airportArea['cityAirport'] as $value)
                                    <option value={{ $value->icao }} selected>{{ $value->icao }}/{{ $value->iata }} {{ $value->name }}</option>
                                @empty
                                    <option value="">Select a City Airport</option>
                                @endforelse
                            </select>

                            @if ($errors->has('cityAirport'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('cityAirport') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group" id="areaAirport-select2">
                            <label for="areaAirport">{{__('Area Airport')}}*</label>
                            <select name="areaAirport[]" id="areaAirport" class="form-control{{ $errors->has('areaAirport') ? ' is-invalid' : '' }}" multiple required>
                                @forelse ($airportArea['areaAirport'] as $value)
                                    @foreach($value->airport as $val)
                                        <option value={{ $val->icao }} selected>{{ $val->icao }}/{{ $val->iata }} {{ $val->name }} ({{ $val->cities->name }})</option>
                                    @endforeach
                                @empty
                                    <option value="">Select a Area Airport</option>
                                @endforelse
                            </select>

                            @if ($errors->has('areaAirport'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('areaAirport') }}</strong>
                                </span>
                            @endif
                        </div>

                        <input type="hidden" id="realAirportArea" name="realAirportArea" value="{{ old('realAirportArea', $realAirportArea) }}">
--}}
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.js-airportArea-form')

@endsection
