@extends('client.layouts.app')
@section('meta')
<title>Sign Up | JetOnset</title>
@endsection

@section('content')
<div class="container header-page-image"></div>

<div class="container signup-page">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Sign Up') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('client.register') }}">
                        @csrf
        
                        <div class="form-group">
                            <div class="col">
                                <p class="mb-0 text-center">New customer?</p>
                                <p class="mb-5 text-center">Please create your account first</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-5">
                                    <label for="first_name">{{ __('First name') }}</label>
                                    <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus>
                                
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
                                    <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>
                                
                                    @if ($errors->has('last_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-5">
                            <label for="email">{{ __('E-Mail') }}</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-5">
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="form-group">
                                    <label for="password-repeat">{{ __('Repeat Password') }}</label>
                                    <input id="password-repeat" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-5">
                            <div class="form-check checkboxes">
                                <input class="form-check-input" type="checkbox" name="privacy" id="privacy">
                                <label class="form-check-label" for="privacy">I confirm that I have read and agree to the <a href="#">Privacy and Data Protection</a></label>
                            </div>

                            @if ($errors->has('privacy'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('privacy') }}</strong>
                                </span>
                            @endif

                            <div class="form-check checkboxes">
                                <input class="form-check-input" type="checkbox" name="terms" id="terms">
                                <label class="form-check-label" for="terms">I confirm that I have read and agree to the <a href="#">General Terms and Conditions</a></label>
                            </div>

                            @if ($errors->has('terms'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('terms') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn">
                                {{ __('Create your account') }}
                            </button>
                        </div>

                        <div class="form-group">
                            <div class="login-page-text">
                                <p class="mb-0 text-center">Have an account, please <a href="{{ route('client.login') }}">Log In</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
