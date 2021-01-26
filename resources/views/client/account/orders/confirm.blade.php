@extends('client.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="mb-4">Flight data</h2>

            <p>Name: {{ $user->first_name }} {{ $user->last_name }}</p>
            <p>Type: {{ $search_type }}</p>
            <p>{{ $pricing->departure }} - {{ $pricing->arrival }}</p>
            <p>Price: &#36;{{ number_format($price, 2, '.', ' ') }}</p>

        </div>

        <?php $messages = Session::get('messages'); ?>

        <div class="col-md-8 profile-page">
            <form method="POST" action="{{ route('client.orders.checkout') }}">
                @csrf

                <h2 class="mb-4">Booking your flight</h2>

                Payment schedule
                10% payment    Full payment


                Summary ..

                <div class="row my-5">
                    <div class="col-md-12">
                        <input type="hidden" name="search_result_id" value="{{ $search_id }}">
                        <input type="hidden" name="search_result_type" value="{{ $search_type }}">
                        <input type="hidden" name="price" value="{{ $price }}">
                        <input type="hidden" name="type" value="{{ $search_type }}">
                        
                        <input type="hidden" name="start_airport_name" value="{{ $start_airport_name }}">
                        <input type="hidden" name="end_airport_name" value="{{ $end_airport_name }}">
                        <input type="hidden" name="departure_at" value="{{ $departure_at }}">
                        <input type="hidden" name="pax" value="{{ $pax }}">
                        
                        <div class="form-group mb-5">
                            <label for="billing_address">{{ __('Billing Address') }}</label>
                            <input type="text" name="billing_address" value="{{ old('billing_address', $user->billing_address) }}" class="form-control{{ $messages && $messages->has('billing_address') ? ' is-invalid' : '' }}" id="billing_address">
                            @if ($messages && $messages->has('billing_address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $messages->first('billing_address') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="billing_address_secondary">{{ __('Billing Address Secondary') }}</label>
                            <input type="text" name="billing_address_secondary" value="{{ old('billing_address_secondary', $user->billing_address_secondary) }}" class="form-control{{ $messages && $messages->has('billing_address_secondary') ? ' is-invalid' : '' }}" id="billing_address_secondary">
                            @if ($messages && $messages->has('billing_address_secondary'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $messages->first('billing_address_secondary') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="billing_country">{{ __('Billing Country') }}</label>
                            <input type="text" name="billing_country" value="{{ old('billing_country', $user->billing_country) }}" class="form-control{{ $messages && $messages->has('billing_country') ? ' is-invalid' : '' }}" id="billing_country">
                            @if ($messages && $messages->has('billing_country'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $messages->first('billing_country') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="billing_city">{{ __('Billing City') }}</label>
                            <input type="text" name="billing_city" value="{{ old('billing_city', $user->billing_city) }}" class="form-control{{ $messages && $messages->has('billing_city') ? ' is-invalid' : '' }}" id="billing_city">
                            @if ($messages && $messages->has('billing_city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $messages->first('billing_city') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="billing_province">{{ __('Billing Province') }}</label>
                            <input type="text" name="billing_province" value="{{ old('billing_province') }}" class="form-control{{ $messages && $messages->has('billing_province') ? ' is-invalid' : '' }}" id="billing_province">
                            @if ($messages && $messages->has('billing_province'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $messages->first('billing_province') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="billing_postcode">{{ __('Billing Postcode') }}</label>
                            <input type="text" name="billing_postcode" value="{{ old('billing_postcode', $user->billing_postcode) }}" class="form-control{{ $messages && $messages->has('billing_postcode') ? ' is-invalid' : '' }}" id="billing_postcode">
                            @if ($messages && $messages->has('billing_postcode'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $messages->first('billing_postcode') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="comment">{{ __('Billing Comment') }}</label>
                            <textarea type="text" name="comment" class="form-control{{ $messages && $messages->has('comment') ? ' is-invalid' : '' }}" id="comment">{{ old('comment') }}</textarea>
                            @if ($messages && $messages->has('comment'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $messages->first('comment') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_accepted" value="on" class="form-check-input{{ $messages && $messages->has('is_accepted') ? ' is-invalid' : '' }}" id="is_accepted" {{ old('is_accepted') == 'on' ? 'checked' : '' }}>
                            <label for="is_accepted">I accept</label>
                            @if ($messages && $messages->has('is_accepted'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $messages->first('is_accepted') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="col text-right mt-3 pr-0">
                                <button type="submit" class="btn btn-primary">Payment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

