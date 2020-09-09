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
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.airports.edit', $airport->id) }}">{{ $airport->name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $airport->name }}</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Edit airport</h6>

                    <form method="POST" action="{{ route('admin.airports.update', $airport->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ old('name', $airport->name) }}" required>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" id="city" name="city" value="{{ old('city', $airport->city) }}" required>

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
                                        <option {{ ($airport->country_id == $country->id ? 'selected' : '' ) }} value="{{ $country->id}}">{{ $country->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="iata">Iata</label>
                            <input type="text" class="form-control{{ $errors->has('iata') ? ' is-invalid' : '' }}" id="iata" name="iata" value="{{ old('iata', $airport->iata) }}" required>

                            @if ($errors->has('iata'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('iata') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="icao">Icao</label>
                            <input type="text" class="form-control{{ $errors->has('icao') ? ' is-invalid' : '' }}" id="icao" name="icao" value="{{ old('icao', $airport->icao) }}" required>

                            @if ($errors->has('icao'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('icao') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" id="latitude" name="latitude" value="{{ old('latitude', $airport->latitude) }}" required>

                            @if ($errors->has('latitude'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('latitude') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" id="longitude" name="longitude" value="{{ old('longitude', $airport->longitude) }}" required>

                            @if ($errors->has('longitude'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('longitude') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="timezone">Timezone</label>
                            <input type="text" class="form-control{{ $errors->has('timezone') ? ' is-invalid' : '' }}" id="timezone" name="timezone" value="{{ old('timezone', $airport->timezone) }}" required>

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

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Delete airport</h5>

                    <form method="POST" action="{{ route('admin.airports.destroy', $airport->id) }}">
                        @csrf
                        @method('DELETE')

                        <p>Are you sure you want to delete this airport? This action cannot be undone.</p>

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
