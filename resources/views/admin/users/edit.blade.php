@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.users.index') }}">Users</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.users.edit', $user->id) }}">{{ $user->full_name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->full_name }}</h5>
                        <h6 class="card-subtitle mb-3 text-muted">Edit user</h6>

                        <div class="form-group">
                            <label for="first_name">First name</label>
                            <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>

                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last name</label>
                            <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>

                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Phone number</label>
                            <input type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">

                            @if ($errors->has('phone_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email', $user->email) }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-0">
                            <label for="password">Password</label>
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Billing address</h5>
                        <h6 class="card-subtitle mb-3 text-muted">Edit user's billing address</h6>

                        <div class="form-group">
                            <label for="billing_address">Address</label>
                            <input type="text" class="form-control mb-3{{ $errors->has('billing_address') ? ' is-invalid' : '' }}" id="billing_address" name="billing_address" value="{{ old('billing_address', $user->billing_address) }}">
                            <input type="text" class="form-control{{ $errors->has('billing_address_secondary') ? ' is-invalid' : '' }}" id="billing_address_secondary" name="billing_address_secondary" value="{{ old('billing_address_secondary', $user->billing_address_secondary) }}" placeholder="Secondary">

                            @if ($errors->has('billing_address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('billing_address') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="billing_country">Country</label>
                            <input type="text" class="form-control{{ $errors->has('billing_country') ? ' is-invalid' : '' }}" id="billing_country" name="billing_country" value="{{ old('billing_country', $user->billing_country) }}">

                            @if ($errors->has('billing_country'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('billing_country') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group mb-sm-3 mb-md-0">
                                    <label for="billing_city">City</label>
                                    <input type="text" class="form-control{{ $errors->has('billing_city') ? ' is-invalid' : '' }}" id="billing_city" name="billing_city" value="{{ old('billing_city', $user->billing_city) }}">

                                    @if ($errors->has('billing_city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-sm-3 mb-md-0">
                                    <label for="billing_state">Province</label>
                                    <input type="text" class="form-control{{ $errors->has('billing_state') ? ' is-invalid' : '' }}" id="billing_state" name="billing_state" value="{{ old('billing_state', $user->billing_state) }}">

                                    @if ($errors->has('billing_province'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_state') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="billing_postcode">Postcode</label>
                                    <input type="text" class="form-control{{ $errors->has('billing_postcode') ? ' is-invalid' : '' }}" id="billing_postcode" name="billing_postcode" value="{{ old('billing_postcode', $user->billing_postcode) }}">

                                    @if ($errors->has('billing_postcode'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_postcode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save changes</button>
    </form>
</div>
@endsection
