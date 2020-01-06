@extends('client.layouts.app')
@section('meta')
<title>Reset Password | JetOnset</title>
@endsection

@section('content')
<div class="container header-page-image"></div>

<div class="container reset-password-page">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('client.password.email') }}">
                        @csrf

                        <div class="form-group">
                            <div class="col">
                                <p class="mb-0 text-center">Forgot your password?</p>
                                <p class="mb-5 text-center">Please enter your email aadress below</p>
                            </div>
                        </div>

                        <div class="form-group mb-5">
                            <label for="email">{{ __('EMail') }}</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="col text-center">
                                <button type="submit" class="btn">
                                    {{ __('Send password reset link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
