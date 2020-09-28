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
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.pricing.edit', $pricing->id) }}">{{ $pricing->departure_city }}</a>
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
                    <h5 class="card-title">{{ $pricing->departure_city }}</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Edit pricing</h6>

                    <form method="POST" action="{{ route('admin.pricing.update', $pricing->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="departure">Departure Airport</label>
                            <input type="text" class="form-control{{ $errors->has('departure') ? ' is-invalid' : '' }}" id="departure" name="departure" value="{{ old('departure', $pricing->departure) }}" autocomplete="off" required>
                            <div id="departureAirportList" style="position: relative;"></div>
                            
                            @if ($errors->has('departure'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('departure') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="arrival">Arrival Airport</label>
                            <input type="text" class="form-control{{ $errors->has('arrival') ? ' is-invalid' : '' }}" id="arrival" name="arrival" value="{{ old('arrival', $pricing->arrival) }}" autocomplete="off" required>
                            <div id="arrivalAirportList" style="position: relative;"></div>
                            
                            @if ($errors->has('arrival'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('arrival') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="time">Time</label>
                            <input type="text" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" min="00:01" max="24:00" id="time" name="time" value="{{ old('time', $pricing->time) }}" required>

                            @if ($errors->has('time'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('time') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="price_turbo">Price Turbo</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('price_turbo') ? ' is-invalid' : '' }}" id="price_turbo" name="price_turbo" value="{{ old('price_turbo', $pricing->price_turbo) }}" required>

                            @if ($errors->has('price_turbo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price_turbo') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="price_light">Price Light</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('price_light') ? ' is-invalid' : '' }}" id="price_light" name="price_light" value="{{ old('price_light', $pricing->price_light) }}" required>

                            @if ($errors->has('price_light'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price_light') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="price_medium">Price Medium</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('price_medium') ? ' is-invalid' : '' }}" id="price_medium" name="price_medium" value="{{ old('price_medium', $pricing->price_medium) }}" required>

                            @if ($errors->has('price_medium'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price_medium') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="price_heavy">Price Heavy</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('price_heavy') ? ' is-invalid' : '' }}" id="price_heavy" name="price_heavy" value="{{ old('price_heavy', $pricing->price_heavy) }}" required>

                            @if ($errors->has('price_heavy'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price_heavy') }}</strong>
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
                    <h5 class="card-title">Delete pricing</h5>

                    <form method="POST" action="{{ route('admin.pricing.destroy', $pricing->id) }}">
                        @csrf
                        @method('DELETE')

                        <p>Are you sure you want to delete this pricing? This action cannot be undone.</p>

                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pricing? This action cannot be undone.')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function(){

        $('#departure').keyup(function(){ 
            var query = $(this).val();
            if(query != ''){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('admin.api.airports') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#departureAirportList').fadeIn();  
                        $('#departureAirportList').html(data);
                    }
                });
            }
        });

        $(document).on('click', '#departureAirportList li', function(e){
            e.preventDefault();
            $('#departure').val($(this).text());
            $('#departureAirportList').fadeOut();
        });
        

        $('#arrival').keyup(function(){ 
            var query = $(this).val();
            if(query != ''){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('admin.api.airports') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#arrivalAirportList').fadeIn();  
                        $('#arrivalAirportList').html(data);
                    }
                });
            }
        });

        $(document).on('click', '#arrivalAirportList li', function(e){
            e.preventDefault();
            $('#arrival').val($(this).text());  
            $('#arrivalAirportList').fadeOut();
        });

   });
</script>

@endsection
