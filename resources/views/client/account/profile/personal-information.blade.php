@extends('client.account.profile.layout')
@section('meta')
<title>Personal Information | JetOnset</title>
@endsection

@section('profile-title')
Profile
@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{ route('client.profile.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="first_name">{{ __('First name') }}</label>
                        <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>

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
                        <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>

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
                        <label for="date_of_birth">{{ __('Date of birth') }}</label>
                        <input id="date_of_birth" type="text" class="profile form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" name="date_of_birth" value="{{ old('date_of_birth', optional($user->date_of_birth)->format('m/d/Y')) }}">
                        @if ($errors->has('date_of_birth'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('date_of_birth') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="phone_number">{{ __('Phone number') }}</label>
                        <input id="phone_number" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">

                        @if ($errors->has('phone_number'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $user->email) }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group mb-5">
                <label for="address">{{ __('Address') }}</label>
                <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address', $user->address) }}">

                @if ($errors->has('address'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="city">{{ __('City') }}</label>
                        <input id="city" type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city', $user->city) }}">

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
                        <input id="state" type="text" class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" name="state" value="{{ old('state', $user->state) }}">

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
                        <input id="country" type="text" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" value="{{ old('country', $user->country) }}">

                        @if ($errors->has('country'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('country') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-5">
                        <label for="postcode">{{ __('Zip code') }}</label>
                        <input id="postcode" type="text" class="form-control{{ $errors->has('postcode') ? ' is-invalid' : '' }}" name="postcode" value="{{ old('postcode', $user->postcode) }}">

                        @if ($errors->has('postcode'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('postcode') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-5">
                        <div class="checkbox" style="margin-left: 20px;">
                            <label class="form-check-label" data-toggle="collapse" data-target="#billingAddressDiffer" aria-expanded="false" aria-controls="billingAddressDiffer">
                                <input type="checkbox" class="form-check-input" {{ $user->has_billing_address ? 'checked' : '' }}>My billing address differ from mailing address
                            </label>
                        </div>
                    </div>

                    <div id="billingAddressDiffer" aria-expanded="false" class="collapse{{ $user->has_billing_address ? ' show' : '' }}">
                        <div class="form-group mb-5">
                            <label for="billing_address">{{ __('Billing address') }}</label>
                            <input id="billing_address" type="text" class="form-control{{ $errors->has('billing_address') ? ' is-invalid' : '' }}" name="billing_address" value="{{ old('billing_address', $user->billing_address) }}">

                            @if ($errors->has('billing_address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('billing_address') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-5">
                                    <label for="billing_city">{{ __('City') }}</label>
                                    <input id="billing_city" type="text" class="form-control{{ $errors->has('billing_city') ? ' is-invalid' : '' }}" name="billing_city" value="{{ old('billing_city', $user->billing_city) }}">

                                    @if ($errors->has('billing_city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-5">
                                    <label for="billing_state">{{ __('State') }}</label>
                                    <input id="billing_state" type="text" class="form-control{{ $errors->has('billing_state') ? ' is-invalid' : '' }}" name="billing_state" value="{{ old('billing_state', $user->billing_state) }}">

                                    @if ($errors->has('billing_state'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_state') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-5">
                                    <label for="billing_country">{{ __('Country') }}</label>
                                    <input id="billing_country" type="text" class="form-control{{ $errors->has('billing_country') ? ' is-invalid' : '' }}" name="billing_country" value="{{ old('billing_country', $user->billing_country) }}">

                                    @if ($errors->has('billing_country'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-5">
                                    <label for="billing_postcode">{{ __('Zip code') }}</label>
                                    <input id="billing_postcode" type="text" class="form-control{{ $errors->has('billing_postcode') ? ' is-invalid' : '' }}" name="billing_postcode" value="{{ old('billing_postcode', $user->billing_postcode) }}">

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

            <div class="form-group mb-0">
                <div class="col text-right mt-3 pr-0">
                    <button type="submit" class="btn">
                        {{ __('Save data') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

    <div class="modal fade" id="under-18" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terms&Conditions</h5>
                </div>
                <div class="modal-body">
                    <p>If you are under 18 years old you cannot make an order.</p>
                    <p>We apologize for inconvenience.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var end = new Date().getFullYear();
        var start = new Date($('#date_of_birth').val()).getFullYear();
        var years = end - start;

        if (years < 18) {
            $('#under-18').modal('show');
        }

        $('#date_of_birth').on('change', function(){
            start = new Date($('#date_of_birth').val()).getFullYear();
            years = end - start;
            if (years < 18) {
                $('#under-18').modal('show');
            }
        });
    });
</script>
@endpush
