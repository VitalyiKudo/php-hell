@extends('client.account.profile.layout')
@section('meta')
<title>Account | JetOnset</title>
@endsection

@section('profile-title')
Account
@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
        <form method="POST" class="mb-5" action="{{ route('client.profile.account.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $user->email) }}" required autocomplete="off">
                    
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="email-confirm">{{ __('Confirm E-Mail') }}</label>
                        <input id="email-confirm" type="email" class="form-control" name="email-confirm" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" autocomplete="off">
                    
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
                        <input id="password-repeat" type="password" class="form-control" name="password_repeat" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col text-right mt-3 pr-0">
                    <button type="submit" class="btn">
                        {{ __('Save data') }}
                    </button>
                </div>
            </div>
        </form>

        <form method="POST" action="{{ route('client.profile.account.destroy', $user->id) }}">
            @csrf
            @method('DELETE')

            <h4>Danger zone</h4>
            <p>This is a permanent action and can't be undone.</p>

            
            <button type="submit" class="btn dlt-btn mt-3">
                {{ __('Delete account') }}
            </button>
        </form>
    </div>
</div>
@endsection
