@extends('client.layouts.app')

@section('meta')
    <title>Jet Booking | Step 3</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script type="text/javascript" src="{{ 'PRODUCTION' == $upper_case_environment  ? "https://web.squarecdn.com/v1/square.js" : "https://sandbox.web.squarecdn.com/v1/square.js" }}"></script>

    <script type="text/javascript">
        window.applicationId = "{{ $applicationId }}";
        window.locationId = "{{ $locationId }}";
    </script>

    <link href="{{ asset('css/sq-payment-form.css') }}" rel="stylesheet">
@endsection

@section('book_page', 'book-page-nav')

@section('content')
    @php
        $time_type = 'time_' . $search_type;
        $priceType = 'price_' . $search_type;
		$type = ($search_type === 'emptyLeg') ? Str::after($search->type_plane, '_') : $search_type;
        $total_price = (is_object($search->price)) ? $search->price->$priceType : $search->price;
    @endphp

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
                        <div class="header-book-class">Category: <span>{{ $type }} jet</span></div>
                    </div>

                    <div class="col-6 col-sm-6 col-md-6 col-lg-2 col-xl-2 text-center">
                        <img src="{{ asset('images/people.png') }}" alt="people" class="rounded"/> <span>{{ !empty($search->pax) ? $search->pax : Config::get("constants.plane.type_plane.$search->type_plane.feature_plane.Passengers") }}</span>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-12 col-md-12">
                        <div class="header-book-time"><span>{{ !empty($search->price->$time_type) ? $search->price->$time_type : '-' }}</span></div>
                    </div>

                </div>

                <div class="row header-book-cities">

                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <p>{{ $search->departureCity->name  }}</p>
                    </div>

                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <p>{{ $search->arrivalCity->name }}</p>
                    </div>

                </div>

            </div>

            <div class="d-none d-md-none d-lg-flex d-xl-flex col-md-3 col-xl-3 booking-row-right">
                <div>
                    <p>Including taxes</p>
                    <p>TOTAL: <span> &#36;{{ number_format($total_price, 2, '.', ' ') }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="booking-bg">

    <div class="container-fluid">

        <div class="row mt-3">

            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <a href="{{ $pervis_confirm_url }}" class="btn btn-light back_arrow">Back to JET TYPE</a>
            </div>

            <div class="d-none d-sm-none d-md-none d-lg-block col-lg-9 col-lg-10 col-xl-7">
                <ul class="booking-breadbranch">
                    <li class="booking-last"><span>1</span>jet select</li>
                    <li class="booking-last"><span>2</span>invoice</li>
                    <li class="booking-active"><span>3</span>DETAILS & PAYMENT</li>
                    <li><span>4</span>SUCCESS</li>
                </ul>

            </div>


        </div>

        <div class="row mt-3">
            <div class="offset-lg-2 offset-xl-2 col-sm-12 col-md-12 col-lg-10 col-xl-7">

                <div class="info-square-block sq-payment-form">

                    {{--<div id="sq-walletbox">
                        <button id="sq-google-pay" class="button-google-pay"></button>
                        <button id="sq-apple-pay" class="sq-apple-pay"></button>
                        <button id="sq-masterpass" class="sq-masterpass"></button>
                        <div class="sq-wallet-divider">
                            <span class="sq-wallet-divider__text">Or</span>
                        </div>
                    </div>--}}

                    <div id="sq-ccbox">
                        <form id="nonce-form" novalidate action="{{ route('client.orders.square', [$search_id, $search_type]) }}" method="post">
                            @csrf
                            <div class="form-titles">your details</div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="first_name">First name*</label>
                                    <input type="text" name="first_name" class="form-control{{ $messages && $messages->has('first_name') ? ' is-invalid' : '' }}" id="first_name" value="{{ $request_method === 'post' ? $params['first_name'] : $user->first_name }}" placeholder="YOUR first name">
                                    @if ($messages && $messages->has('first_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $messages->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name">Last name*</label>
                                    <input type="text" name="last_name" class="form-control{{ $messages && $messages->has('last_name') ? ' is-invalid' : '' }}" id="last_name" value="{{ $request_method === 'post' ? $params['last_name'] : $user->last_name }}" placeholder="YOUR Last name">
                                    @if ($messages && $messages->has('last_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $messages->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="birth_date">Birth date*</label>
                                    <input type="text" name="birth_date" class="form-control{{ $messages && $messages->has('birth_date') ? ' is-invalid' : '' }}" id="birth_date" value="{{ $request_method === 'post' ? $params['birth_date'] : old('date_of_birth', optional($user->date_of_birth)->format('m/d/Y'))}}" placeholder="date">
                                    @if ($messages && $messages->has('birth_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $messages->first('birth_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="form-control" id="gender">
                                        <option value="" {{ ($params['gender'] == "") ? 'selected' : '' }}> - </option>
                                        <option value="Male" {{ ($params['gender'] == "Male") ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ ($params['gender'] == "Female") ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="title">Title</label>
                                    <select name="title" class="form-control" id="title">
                                        <option value="" {{ ($params['title'] == "") ? 'selected' : '' }}> - </option>
                                        <option value="Mr" {{ ($params['title'] == "Mr") ? 'selected' : '' }}>Mr</option>
                                        <option value="Mrs" {{ ($params['title'] == "Mrs") ? 'selected' : '' }}>Mrs</option>
                                        <option value="Ms" {{ ($params['title'] == "Ms") ? 'selected' : '' }}>Ms</option>
                                        <option value="Sir" {{ ($params['title'] == "Sir") ? 'selected' : '' }}>Sir</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comments">Comments</label>
                                <input type="text" name="comments" class="form-control" id="comments" value="{{ $params['comments'] }}" placeholder="Your preferences, tastes, etc">
                            </div>

                            <div class="form-titles mt-5">payment</div>

                            <div class="wrapper">

                                <div id="card-container"></div>

                                <ul id="error"></ul>

                                <ul id="error-card">
                                    @foreach ($cart_errors as  $cart_error)
                                        <li>{!! $cart_error !!}</li>
                                    @endforeach
                                </ul>

                                <input type="hidden" id="card-nonce" name="nonce" value="">

                                <div class="form-group agree-block pt-3">
                                    <div class="form-check text-center">
                                        <input class="form-check-input{{ $messages && $messages->has('is_accepted') ? ' is-invalid' : '' }}" name="is_accepted" value="on" type="checkbox" id="gridCheck" {{ $params['is_accepted'] == 'on' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridCheck">I agree with Cancellation policy</label>
                                        @if ($messages && $messages->has('is_accepted'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $messages->first('is_accepted') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="sq-field text-center abs-reset-button pb-5">
                                    <button id="card-button" type="button" class="sq-button">CONFIRM & PAY</button>
                                </div>
                                <span id="payment-flow-message"></span>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection


@push('scripts')
    <script src="{{ asset('SquareSDK/js/sq-card-pay.js') }}" type="text/javascript"></script>
    <script src="{{ asset('SquareSDK/js/sq-payment-flow.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

    $(document).ready(function(){


        $(function() {
            $('input[name="birth_date"]').daterangepicker({
                opens: 'left',
                keepEmptyValues: true,
                singleDatePicker: true,
            });

            //$('input[name="birth_date"]').val('');
            //$('input[name="flightDate"]').attr("placeholder","Date & Time");

        });
    });

    </script>

@endpush
