@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.emptyLegs.index') }}">{{__('Empty Legs')}}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.emptyLegs.edit', $emptyLeg['id']) }}">
                            {{ $emptyLeg['dateDeparture']->format('m-d-Y') }}
                            ({{ $emptyLeg['operatorName'] }})
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('Edit')}}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $emptyLeg['dateDeparture']->format('m-d-Y') }}  ({{ $emptyLeg['operatorName'] }})</h5>
                    <h6 class="card-subtitle mb-3 text-muted">{{__('Edit Empty Leg')}}</h6>

                    <form method="POST" action="{{ route('admin.emptyLegs.update', $emptyLeg['id']) }}" id="quickForm">
                        @csrf
                        @method('PUT')

                        <div class="form-group" id="icaoDeparture-select2">
                            <label for="icaoDeparture">{{__('Departure Airport')}}*</label>
                            <select name="icaoDeparture" id="icaoDeparture" class="form-control{{ $errors->has('icaoDeparture') ? ' is-invalid' : '' }}" required>
                                <option value={{ $emptyLeg['icaoDeparture'] }} selected>{{ $emptyLeg['icaoDeparture'] ? $emptyLeg['airportDeparture'] . ' ('. $emptyLeg['icaoDeparture'] . ')' : '' }}</option>

                            </select>
                            <input type="hidden" id="geoNameIdCityDeparture" name="geoNameIdCityDeparture" value="{{ old('geoNameIdCityDeparture', $emptyLeg['geoNameIdCityDeparture']) }}">

                            @if ($errors->has('icaoDeparture'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('icaoDeparture') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group" id="icaoArrival-select2">
                            <label for="icaoArrival">{{__('Arrival Airport')}}*</label>
                            <select name="icaoArrival" id="icaoArrival" class="form-control{{ $errors->has('icaoArrival') ? ' is-invalid' : '' }}" required>
                                <option value={{ $emptyLeg['icaoArrival'] }} selected>{{ $emptyLeg['icaoArrival'] ? $emptyLeg['airportArrival'] . ' ('. $emptyLeg['icaoArrival'] . ')' : '' }}</option>

                            </select>
                            <input type="hidden" id="geoNameIdCityArrival" name="geoNameIdCityArrival" value="{{ old('geoNameIdCityArrival', $emptyLeg['geoNameIdCityArrival']) }}">

                            @if ($errors->has('icaoArrival'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('icaoArrival') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group" id="operatorEmail-select2">
                            <label for="operatorEmail">{{__('Operator')}}*</label>
                            <select name="operatorEmail" id="operatorEmail" class="form-control{{ $errors->has('operatorEmail') ? ' is-invalid' : '' }}" required>
                                <option value={{ $emptyLeg['operatorEmail'] }} selected>{{ $emptyLeg['operatorEmail'] ? $emptyLeg['operatorName'] . ' ('. $emptyLeg['operatorEmail'] . ')' : '' }}</option>
                            </select>

                            @if ($errors->has('operatorEmail'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('operatorEmail') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="typePlane">{{__('Plane Type')}}*</label>
                            <select name="typePlane" id="typePlane" class="form-control{{ $errors->has('typePlane') ? ' is-invalid' : '' }}" required>
                                @forelse ($typePlanes as $keyPlane => $valPlane)
                                    <option value={{ $keyPlane }}{{ ($emptyLeg['typePlane'] === $keyPlane) ? ' selected' : '' }}>{{ $valPlane['type'] }}</option>
                                @empty
                                    <p>No type Planes</p>
                                @endforelse

                            </select>

                            @if ($errors->has('typePlane'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('typePlane') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="price">{{__('Price')}}*</label>
                            <input type="number" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" id="price" name="price" value="{{ old('price', $emptyLeg['price']) }}" placeholder="Enter price">

                            @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="dateDeparture">{{__('Date')}}*</label>
                            <input type="date" class="form-control{{ $errors->has('dateDeparture') ? ' is-invalid' : '' }}" id="dateDeparture" name="dateDeparture" value="{{ old('dateDeparture', $emptyLeg['dateDeparture']->format('Y-m-d')) }}" required>

                            @if ($errors->has('dateDeparture'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('dateDeparture') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="hidden" name="active" value="0">
                                <input type="checkbox" class="form-check-input" name="active" value="1" {{ ($emptyLeg['active'] === 1) ? 'checked' : '' }}>
                                <label for="active">{{__('Active')}}</label>
                            </div>

                            @if ($errors->has('active'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('active') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Delete Empty Leg</h5>

                    <form method="POST" action="{{ route('admin.emptyLegs.destroy', $emptyLeg['id']) }}">
                        @csrf
                        @method('DELETE')

                        <p>{{__('Are you sure you want to delete this emptyLeg? This action cannot be undone.')}}</p>

                        <button type="submit" class="btn btn-danger" onclick="return confirm('{{__('Are you sure you want to delete this emptyLeg? This action cannot be undone.')}}')">{{__('Delete')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.js-emptyLeg-form')

@endsection
