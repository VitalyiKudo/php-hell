@extends('client.layouts.app')

@section('meta')
    <title>Jet Booking | Step 2</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
@endsection

@section('book_page', 'book-page-nav')

@section('content')


<div class="container header-page-image header-page-image-bg"></div>
<div class="section main-search-page header-page-image-booking-two">
    <div class="container-fluid">
        <div class="row">
            
            <div class="d-none d-md-none d-lg-flex d-xl-flex col-md-3 col-xl-3 booking-left">
                <p class="booking-row-left">ORDER PAYMENT:</p>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="row">

                    <div class="col-6 col-sm-6 col-md-6 col-lg-5 col-xl-5">
                        <div class="header-book-class">Category: <span>{{ $search_type }} jet</span></div>
                    </div>

                    <div class="col-6 col-sm-6 col-md-6 col-lg-2 col-xl-2 text-center">
                        <img src="{{ asset('images/people.png') }}" alt="people" class="rounded"/> <span>2</span>
                    </div>

                </div>
                
                <div class="row">

                    <div class="col-sm-12 col-md-12">
                        <div class="header-book-time"><span>{{ $time }}</span></div>
                    </div>

                </div>
                
                <div class="row header-book-cities">

                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <p>{{ $pricing->departure }}</p>
                    </div>
                    
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <p>{{ $pricing->arrival }}</p>
                    </div>

                </div>
                
            </div>
            
            <div class="d-none d-md-none d-lg-flex d-xl-flex col-md-3 col-xl-3 booking-row-right">
                <div>
                    <p>Including taxes</p>
                    <p>TOTAL: <span> &#36;{{ number_format($price, 2, '.', ' ') }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="booking-bg">

    <div class="container-fluid">

        <div class="row mt-3">

            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <a href="{{ URL::previous() }}" class="btn btn-light back_arrow">Back to JET TYPE</a>
            </div>

            <div class="d-none d-sm-none d-md-none d-lg-block col-lg-9 col-lg-10 col-xl-7">
                <ul class="booking-breadbranch">
                    <li class="booking-last"><span>1</span>jet select</li>
                    <li class="booking-active"><span>2</span>invoice</li>
                    <li><span>3</span>DETAILS & PAYMENT</li>
                    <li><span>4</span>SUCCESS</li>
                </ul>

            </div>
            
            
        </div>

        <div class="row mt-3">
            <div class="offset-lg-2 offset-xl-2 col-sm-12 col-md-12 col-lg-10 col-xl-7">
                <div class="details-block">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2">invoice details:</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if($feeses)
                                @foreach ($feeses as $fees)
                                    @if($fees->active == 1)
                                        <tr>
                                            <td>{{ $fees->item }}:</td>
                                            <td>{{ $fees->type }}{{ $fees->amount }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif

                            <tr class="total">
                                <td>Total:</td>
                                <td>&#36;{{ number_format($total_price, 2, '.', ' ') }}</td>
                            </tr>
                            <tr class="pay-button-block">
                                <td colspan="2">
                                    <button type="button" class="pay-button">TO PAYMENT</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center" style="display: none;">
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

</div>

@endsection

