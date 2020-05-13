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
        <form method="POST" action="{{ route('client.profile.companion.update') }}">
            @csrf
            @method('put')

            <div class="row names-block">
                <div class="col-md-12 mb-4">
                    <div class="form-group names-list mb-2">
                        <!-- <div class="row">
                            <div class="col-auto">
                                <button type="button" class="plus-btn">
                                    <img src="/images/plus2.png" class="icon-img" alt="...">
                                </button> 
                            </div>
                        </div> -->
                    </div>              
                </div>
            </div> 

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="first_name">{{ __('First name') }}</label>
                        <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                               name="first_name" value="{{ $companion->first_name }}" required>

                        @if ($errors->has('first_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="last_name">{{ __('Last name') }}</label>
                        <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name"
                               value="{{ $companion->last_name }}" required>

                        @if ($errors->has('last_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="dob">{{ __('Date of birth') }}</label>
                        <input id="dob" type="text" class="companion form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" 
                            name="dob" value="{{ $companion->dob }}">

                        @if ($errors->has('dob'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('dob') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" 
                        value="{{ old('email', $companion->email) }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="address">{{ __('Home aadress') }}</label>
                        <input id="address" type="text" class="form-control{{ $errors->has('address') ? 
                            ' is-invalid' : '' }}" name="address" value="{{ old('address', $companion->address) }}">

                        @if ($errors->has('address'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="street_no">{{ __('Street name and number') }}</label>
                        <input id="street_no" type="text" class="form-control{{ $errors->has('street_no') ? ' is-invalid' : '' }}" name="street_no" value="{{ old('street_no', $companion->street_no) }}">

                        @if ($errors->has('street_no'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('street_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="city">{{ __('City') }}</label>
                        <input id="city" type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" 
                        name="city" value="{{ old('city', $companion->city) }}">

                        @if ($errors->has('city'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="state">{{ __('State') }}</label>
                        <input id="state" type="text" class="form-control{{ $errors->has('state') 
                            ? ' is-invalid' : '' }}" name="state" value="{{ old('state', $companion->state) }}">

                        @if ($errors->has('state'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('state') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="country">{{ __('Country') }}</label>
                        <input id="country" type="text" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" 
                        name="country" value="{{ old('country', $companion->country) }}">

                        @if ($errors->has('country'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('country') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="zipcode">{{ __('Zip code') }}</label>
                        <input id="zipcode" type="text" class="form-control{{ $errors->has('zipcode') ?
                             ' is-invalid' : '' }}" name="zipcode" value="{{ old('zipcode', $companion->zipcode) }}">
                    
                        @if ($errors->has('zipcode'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('zipcode') }}</strong>
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
