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
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">New pricing</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Fill the details of a new pricing</h6>

                    <form method="POST" action="{{ route('admin.pricing.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="departure">Departure Airport</label>
                            <input type="text" class="form-control{{ $errors->has('departure') ? ' is-invalid' : '' }}" id="departure" name="departure" value="{{ old('departure') }}" autocomplete="off" required>
                            <div id="departureCityList" style="position: relative;"></div>
                            
                            @if ($errors->has('departure'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('departure') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="arrival">Arrival Airport</label>
                            <input type="text" class="form-control{{ $errors->has('arrival') ? ' is-invalid' : '' }}" id="arrival" name="arrival" value="{{ old('arrival') }}" autocomplete="off" required>
                            <div id="arrivalCityList" style="position: relative;"></div>
                            
                            @if ($errors->has('arrival'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('arrival') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="time_turbo">Time Turbo</label>
                            <input type="text" class="form-control{{ $errors->has('time_turbo') ? ' is-invalid' : '' }}" id="time_turbo" name="time_turbo" value="{{ old('time_turbo') }}">

                            @if ($errors->has('time_turbo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('time_turbo') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="price_turbo">Price Turbo</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('price_turbo') ? ' is-invalid' : '' }}" id="price_turbo" name="price_turbo" value="{{ old('price_turbo') }}">

                            @if ($errors->has('price_turbo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price_turbo') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="time_light">Time Light</label>
                            <input type="text" class="form-control{{ $errors->has('time_light') ? ' is-invalid' : '' }}" id="time_light" name="time_light" value="{{ old('time_light') }}">

                            @if ($errors->has('time_light'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('time_light') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="price_light">Price Light</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('price_light') ? ' is-invalid' : '' }}" id="price_light" name="price_light" value="{{ old('price_light') }}">

                            @if ($errors->has('price_light'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price_light') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="time_medium">Time Medium</label>
                            <input type="text" class="form-control{{ $errors->has('time_medium') ? ' is-invalid' : '' }}" id="time_medium" name="time_medium" value="{{ old('time_medium') }}">

                            @if ($errors->has('time_medium'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('time_medium') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="price_medium">Price Medium</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('price_medium') ? ' is-invalid' : '' }}" id="price_medium" name="price_medium" value="{{ old('price_medium') }}">

                            @if ($errors->has('price_medium'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price_medium') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="time_heavy">Time Heavy</label>
                            <input type="text" class="form-control{{ $errors->has('time_heavy') ? ' is-invalid' : '' }}" id="time_heavy" name="time_heavy" value="{{ old('time_heavy') }}">

                            @if ($errors->has('time_heavy'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('time_heavy') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="price_heavy">Price Heavy</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('price_heavy') ? ' is-invalid' : '' }}" id="price_heavy" name="price_heavy" value="{{ old('price_heavy') }}">

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
</div>

<script type="application/javascript">
    $(document).ready(function(){

        $('#departure').keyup(function(){ 
            var query = $(this).val();
            if(query != ''){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('admin.api.cities') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#departureCityList').fadeIn();  
                        $('#departureCityList').html(data);
                    }
                });
            }
        });

        $(document).on('click', '#departureCityList li', function(e){
            e.preventDefault();
            $('#departure').val($(this).text());
            $('#departureCityList').fadeOut();
        });
        

        $('#arrival').keyup(function(){ 
            var query = $(this).val();
            if(query != ''){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('admin.api.cities') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#arrivalCityList').fadeIn();  
                        $('#arrivalCityList').html(data);
                    }
                });
            }
        });

        $(document).on('click', '#arrivalCityList li', function(e){
            e.preventDefault();
            $('#arrival').val($(this).text());  
            $('#arrivalCityList').fadeOut();
        });

   });
</script>

@endsection
