@extends('client.layouts.app')
@section('meta')
<title>Log In | JetOnset</title>
@endsection

@section('content')
<div class="container header-page-image"></div>

<div class="container login-page">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('client.login') }}">
                        @csrf

                        <div class="form-group">
                            <div class="col">
                                <p class="mb-0 text-center">Welcome back!</p>
                                <p class="mb-5 text-center">Please login in with your account</p>
                            </div>
                        </div>

                        <div class="form-group mb-5">
                            <label for="email">{{ __('EMail') }}</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group text mb-4">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group text-center mb-5">
                            <div class="form-check checkboxes">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="{{ old('remember') ? 'checked' : '' }}">
                                <label class="form-check-label" for="remember">{{ __('Remember me') }}</label>
                            </div>
                        </div>

                        @if (Route::has('client.password.request'))
                            <div class="form-group">
                                <div class="col login-page-text">
                                    <a href="{{ route('client.password.request') }}">
                                        <p class="mb-0 text-center">Forgot your password?</p>
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="col text-center">
                                <button type="submit" class="btn">
                                    {{ __('Log to your account') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col login-page-text">
                                <p class="mb-0 text-center">Don't have an account, please <a href="{{ route('client.register') }}">Sign Up</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
