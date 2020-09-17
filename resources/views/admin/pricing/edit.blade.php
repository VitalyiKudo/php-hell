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
                            <label for="departure_city">Departure City</label>
                            <input type="text" class="form-control{{ $errors->has('departure_city') ? ' is-invalid' : '' }}" id="departure_city" name="departure_city" value="{{ old('departure_city', $pricing->departure_city) }}" autocomplete="off" required>
                            <div id="departureList" style="position: relative;"></div>
                            
                            @if ($errors->has('departure_city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('departure_city') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="departure_city_to_airport">Airport of Departure City</label>
                            <input type="text" class="form-control{{ $errors->has('departure_city_to_airport') ? ' is-invalid' : '' }}" id="departure_city_to_airport" name="departure_city_to_airport" value="{{ old('departure_city_to_airport', $pricing->departure_city_to_airport) }}" autocomplete="off" required>
                            <div id="departureAirportList" style="position: relative;"></div>
                            
                            @if ($errors->has('departure_city_to_airport'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('departure_city_to_airport') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="arrival_city">Arrival City</label>
                            <input type="text" class="form-control{{ $errors->has('arrival_city') ? ' is-invalid' : '' }}" id="arrival_city" name="arrival_city" value="{{ old('arrival_city', $pricing->arrival_city) }}" autocomplete="off" required>
                            <div id="arrivalList" style="position: relative;"></div>
                            
                            @if ($errors->has('arrival_city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('arrival_city') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="arrival_city_to_airport">Airport of Arrival City</label>
                            <input type="text" class="form-control{{ $errors->has('arrival_city_to_airport') ? ' is-invalid' : '' }}" id="arrival_city_to_airport" name="arrival_city_to_airport" value="{{ old('arrival_city_to_airport', $pricing->arrival_city_to_airport) }}" autocomplete="off" required>
                            <div id="arrivalAirportList" style="position: relative;"></div>
                            
                            @if ($errors->has('arrival_city_to_airport'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('arrival_city_to_airport') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="price_first">First Price</label>
                            <input type="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" id="price_first" name="price_first" value="{{ old('price_first', $pricing->price_first) }}" required>

                            @if ($errors->has('price_first'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price_first') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="price_second">Second Price</label>
                            <input type="price" class="form-control{{ $errors->has('price_second') ? ' is-invalid' : '' }}" id="price_second" name="price_second" value="{{ old('price_second', $pricing->price_second) }}" required>

                            @if ($errors->has('price_second'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price_second') }}</strong>
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

        $('#departure_city').keyup(function(){ 
            var query = $(this).val();
            if(query != ''){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('admin.api.cities') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#departureList').fadeIn();  
                        $('#departureList').html(data);
                    }
                });
            }
        });

        $(document).on('click', '#departureList li', function(e){
            e.preventDefault();
            $('#departure_city').val($(this).text());  
            $('#departureList').fadeOut();
        });


        $('#departure_city_to_airport').keyup(function(){ 
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
            $('#departure_city_to_airport').val($(this).text());  
            $('#departureAirportList').fadeOut();
        });
       
       
        $('#arrival_city').keyup(function(){ 
            var query = $(this).val();
            if(query != ''){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('admin.api.cities') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#arrivalList').fadeIn();  
                        $('#arrivalList').html(data);
                    }
                });
            }
        });

        $(document).on('click', '#arrivalList li', function(e){
            e.preventDefault();
            $('#arrival_city').val($(this).text());  
            $('#arrivalList').fadeOut();
        });


        $('#arrival_city_to_airport').keyup(function(){ 
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
            $('#arrival_city_to_airport').val($(this).text());  
            $('#arrivalAirportList').fadeOut();
        });

   });
</script>

@endsection
