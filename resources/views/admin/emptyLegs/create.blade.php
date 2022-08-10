@extends('admin.layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.emptyLegs.index') }}">Empty Legs</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>New Empty Leg</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Fill the details of a new Empty Leg</h6>

                    <form method="POST" action="{{ route('admin.emptyLegs.store') }}" id="quickForm">
                        @csrf
                        @method('POST')

                        <div class="form-group" id="icaoDeparture-select2">
                            <label for="icaoDeparture">Departure Airport*</label>
                            <select name="icaoDeparture" id="icaoDeparture" class="form-control{{ $errors->has('icaoDeparture') ? ' is-invalid' : '' }}" required>

                            </select>
                            <input type="hidden" id="geoNameIdCityDeparture" name="geoNameIdCityDeparture" value="{{ old('geoNameIdCityDeparture') }}">
                            @if ($errors->has('icaoDeparture'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('icaoDeparture') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group" id="icaoArrival-select2">
                            <label for="icaoArrival">Arrival Airport*</label>
                            <select name="icaoArrival" id="icaoArrival" class="form-control{{ $errors->has('icaoArrival') ? ' is-invalid' : '' }}" required>

                            </select>
                            <input type="hidden" id="geoNameIdCityArrival" name="geoNameIdCityArrival" value="{{ old('geoNameIdCityArrival') }}">
                            @if ($errors->has('icaoArrival'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('icaoArrival') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group" id="operatorEmail-select2">
                            <label for="operatorEmail">Operator*</label>
                            <select name="operatorEmail" id="operatorEmail" class="form-control{{ $errors->has('operatorEmail') ? ' is-invalid' : '' }}" required>

                            </select>

                            @if ($errors->has('operatorEmail'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('operatorEmail') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="typePlane">Plane Type*</label>
                            <select name="typePlane" id="typePlane" class="color-placeholder required form-control{{ $errors->has('typePlane') ? ' is-invalid' : '' }}" required>
                                <option value="">Select a Plane Type</option>
                                @forelse ($typePlanes as $keyPlane => $valPlane)
                                    <option value={{ $keyPlane }}>{{ $valPlane['type'] }}</option>
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
                            <label for="price">Price*</label>
                            <input type="number" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" id="price" name="price" value="{{ old('price') }}" placeholder="Enter price">

                            @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="dateDeparture">{{__('Date')}}*</label>
                            <div class="input-group">
                                <div class="input-group-prepend iconDateDeparture">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                            <input type="text" class="form-control{{ $errors->has('dateDeparture') ? ' is-invalid' : '' }}" id="dateDeparture" name="dateDeparture" value="" placeholder="Enter date">

                            @if ($errors->has('dateDeparture'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('dateDeparture') }}</strong>
                                </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="active" value="1" {{ old('active') ? 'checked' : '' }}>
                                <label for="active">{{__('Active')}}</label>
                            </div>

                            @if ($errors->has('active'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('active') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.js-emptyLeg-form')

@endsection
