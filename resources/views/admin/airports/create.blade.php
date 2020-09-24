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
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">New airport</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Fill the details of a new airport</h6>

                    <form method="POST" action="{{ route('admin.airports.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}" required>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" id="city" name="city" value="{{ old('city') }}" required>

                            @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="country">Country</label>

                                <select class="form-control" name="country_id" id="country">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id}}">{{ $country->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="iata">IATA</label>
                            <input type="text" class="form-control{{ $errors->has('iata') ? ' is-invalid' : '' }}" id="iata" name="iata" value="{{ old('iata') }}">

                            @if ($errors->has('iata'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('iata') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="icao">ICAO</label>
                            <input type="text" class="form-control{{ $errors->has('icao') ? ' is-invalid' : '' }}" id="icao" name="icao" value="{{ old('icao') }}">

                            @if ($errors->has('icao'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('icao') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" id="latitude" name="latitude" value="{{ old('latitude') }}">

                            @if ($errors->has('latitude'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('latitude') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" id="longitude" name="longitude" value="{{ old('longitude') }}">

                            @if ($errors->has('longitude'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('longitude') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="timezone">Timezone</label>
                            <input type="text" class="form-control{{ $errors->has('timezone') ? ' is-invalid' : '' }}" id="timezone" name="timezone" value="{{ old('timezone') }}">

                            @if ($errors->has('timezone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('timezone') }}</strong>
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
@endsection
