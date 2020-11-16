@extends('client.account.profile.layout')
@section('meta')
<title>Companions | JetOnset</title>
@endsection

@section('profile-title')
Companions
@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{ route('client.profile.companions.store') }}">
            @csrf

            <div class="row names-block">
                <div class="col-md-12 mb-4">
                    <div class="form-group names-list mb-2">
                        <div class="row">
                            <div class="col-auto">
                                <button type="button" class="plus-btn">
                                    <img src="/images/plus2.webp" loading="lazy" class="icon-img" alt="...">
                                </button> 
                            </div>
                        </div>
                    </div>              
                </div>
            </div> 

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="companion_first_name">{{ __('First name') }}</label>
                        <input id="first_name" type="text" class="form-control{{ $errors->has('companion_first_name') ? ' is-invalid' : '' }}" name="companion_first_name" value="{{ old('companion_first_name', $user->companion_first_name) }}" required>
                    
                        @if ($errors->has('companion_first_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('companion_first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="companion_last_name">{{ __('Last name') }}</label>
                        <input id="companion_last_name" type="text" class="form-control{{ $errors->has('companion_last_name') ? ' is-invalid' : '' }}" name="companion_last_name" value="{{ old('companion_last_name', $user->companion_last_name) }}" required>
                    
                        @if ($errors->has('companion_last_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('companion_last_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="companion_date_of_birth">{{ __('Date of birth') }}</label>
                        <input id="companion_date_of_birth" type="text" class="companion form-control{{ $errors->has('companion_date_of_birth') ? ' is-invalid' : '' }}" name="companion_date_of_birth" value="{{ old('companion_date_of_birth', optional($user->companion_date_of_birth)->format('d.m.Y')) }}">
                    
                        @if ($errors->has('companion_date_of_birth'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('companion_date_of_birth') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="companion_email">{{ __('Email') }}</label>
                        <input id="companion_email" type="email" class="form-control{{ $errors->has('companion_email') ? ' is-invalid' : '' }}" name="companion_email" value="{{ old('companion_email', $user->companion_email) }}" required>
                    
                        @if ($errors->has('companion_email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('companion_email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="companion_home_address">{{ __('Home aadress') }}</label>
                        <input id="companion_home_aadress" type="text" class="form-control{{ $errors->has('companion_home_aadress') ? ' is-invalid' : '' }}" name="companion_home_address" value="{{ old('companion_home_aadress', $user->companion_home_aadress) }}">
                    
                        @if ($errors->has('companion_home_aadress'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('companion_home_aadress') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="companion_street_name_and_number">{{ __('Street name and number') }}</label>
                        <input id="companion_street_name_and_number" type="text" class="form-control{{ $errors->has('companion_street_name_and_number') ? ' is-invalid' : '' }}" name="companion_street_name_and_number" value="{{ old('companion_street_name_and_number', $user->companion_street_name_and_number) }}">
                    
                        @if ($errors->has('companion_street_name_and_number'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('companion_street_name_and_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="companion_city">{{ __('City') }}</label>
                        <input id="companion_city" type="text" class="form-control{{ $errors->has('companion_city') ? ' is-invalid' : '' }}" name="companion_city" value="{{ old('companion_city', $user->companion_city) }}">
                    
                        @if ($errors->has('companion_city'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('companion_city') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="companion_state">{{ __('State') }}</label>
                        <input id="companion_state" type="text" class="form-control{{ $errors->has('companion_state') ? ' is-invalid' : '' }}" name="companion_state" value="{{ old('companion_state', $user->companion_state) }}">
                    
                        @if ($errors->has('companion_state'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('companion_state') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="companion_country">{{ __('Country') }}</label>
                        <input id="companion_country" type="text" class="form-control{{ $errors->has('companion_country') ? ' is-invalid' : '' }}" name="companion_country" value="{{ old('companion_country', $user->companion_country) }}">
                    
                        @if ($errors->has('companion_country'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('companion_country') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="companion_zip_code">{{ __('Zip code') }}</label>
                        <input id="companion_zip_code" type="text" class="form-control{{ $errors->has('companion_zip_code') ? ' is-invalid' : '' }}" name="companion_zip_code" value="{{ old('companion_zip_code', $user->companion_zip_code) }}">
                    
                        @if ($errors->has('companion_zip_code'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('companion_zip_code') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group float-right mb-0">
                <div class="col text-right mt-3 pr-0">
                    <button type="submit" class="btn">
                        {{ __('Save data') }}
                    </button>
                </div>
            </div>

            <div class="form-group float-left mb-0">
                <div class="col text-right mt-3 pl-0">
                    <button type="submit" class="btn dlt-btn">
                        {{ __('Delete persona') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
