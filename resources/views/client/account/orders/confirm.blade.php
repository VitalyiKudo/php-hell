@extends('client.layouts.app')

@section('meta')
    <title>Jet Booking | Step 2</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
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
                        <div class="header-book-time"><span>{{ !empty($search->price->$time_type) ? $search->price->$time_type : '-'}}</span></div>
                    </div>

                </div>

                <div class="row header-book-cities">

                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <p>{{ $search->departureCity->name }}</p>
                    </div>

                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <p>{{ $search->arrivalCity->name }}</p>
                    </div>

                </div>

            </div>

            <div class="d-none d-md-none d-lg-flex d-xl-flex col-md-3 col-xl-3 booking-row-right">
                <div>
                    <p>Including taxes</p>
                    @php

                    @endphp
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
                <a href="{{ $pervis_search_url }}" class="btn btn-light back_arrow">Back to JET TYPE</a>
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
                            <tr>
                                <td>Price:</td>
                                <td>&#36;{{ number_format($total_price, 2, '.', ' ') }}</td>
                            </tr>
                            @if(!empty($feeses))
                                @foreach ($feeses as $fees)
                                    @if($fees->active == 1)
                                        <tr>
                                            <td>{{ $fees->item }}:</td>
                                            <td>{{ $fees->sall ? '-' : '+' }} {{ $fees->type }}{{ number_format($fees->amount, 2, '.', ' ') }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif

                            <tr class="total">
                                <th colspan="2">
                                    <div class="total-div">
                                        <div>Total:</div>
                                        <div>&#36;{{ number_format($total_price, 2, '.', ' ') }}</div>
                                    </div>
                                </th>
                            </tr>
                            <tr class="pay-button-block">
                                <td colspan="2">
                                    <a href="{{ route('client.orders.square', [$search_id, $search_type]) }}" class="pay-button">TO PAYMENT</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="modal fade" id="ToS" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms of service</h5>
            </div>
            <div class="modal-body">
                <p>The flight quote listed above is an estimate and is not guaranteed.</p>
                <p>After we receive your request an Aviation Advisor will contact you to discuss any special requirements and provide you with a final flight price and payment options, at which time you can choose to confirm the booking. For the avoidance of doubt this is a fully cancelable request and you will incur no charges prior to finalizing the booking.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Approve</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.pay-button').click(function(e){
            e.preventDefault();
            $('#ToS').modal('show');
            $('#ToS button').click(function(){
                location.href =$('.pay-button').attr('href');
            });
        });
    });
</script>
@endpush
