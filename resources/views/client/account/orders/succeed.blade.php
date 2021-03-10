@extends('client.layouts.app')

@section('meta')
    <title>Jet Booking | Step 4</title>
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
                        <img src="{{ asset('images/people.png') }}" alt="people" class="rounded"/> <span>{{ $search->pax }}</span>
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
                    <p>TOTAL: <span> &#36;{{ number_format($order->price, 2, '.', ' ') }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="booking-bg">

    <div class="container-fluid">

        <div class="row mt-3">

            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                
            </div>

            <div class="d-none d-sm-none d-md-none d-lg-block col-lg-9 col-lg-10 col-xl-7">
                <ul class="booking-breadbranch">
                    <li class="booking-last"><span>1</span>jet select</li>
                    <li class="booking-last"><span>2</span>invoice</li>
                    <li class="booking-last"><span>3</span>DETAILS & PAYMENT</li>
                    <li class="booking-active"><span>4</span>SUCCESS</li>
                </ul>

            </div>
            
            
        </div>

        <div class="row mt-3">
            <div class="offset-lg-2 offset-xl-2 col-sm-12 col-md-12 col-lg-10 col-xl-7">
                <div class="info-succeed-block">
                    
                    
                    
                    
                    
                    
                    <div class="card-body">
                        <div class="card-inner-body pl-4">
                            <div class="custom-flight-page">
                                <img src="{{ asset('images/ticket.png') }}" alt="ticket" class="rounded mx-auto d-block"> 
                                <div class="succeed-payment">Your payment <span>&#36;{{ number_format($order->price, 2, '.', ' ') }}</span> has been successful!</div>
                                <div class="succeed-order">Order number: <span>#{{ $order_id }}</span></div>
                                <a href="{{ route('client.profile.account.index') }}">View in Cabinet</a>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    
                </div>
            </div>
        </div>
        

    </div>

</div>

@endsection