@extends('client.layouts.app')
@section('meta')
<title>Orders | JetOnset</title>
@endsection

@section('content')
<div class="container header-page-image"></div>

<div class="container order-page">
    <div class="row">
        <div class="col-lg-4">
            <h2 class="mb-4 left-order-title">Order</h2>
            <div class="left-order">
                <p class="mb-3">Sort search request by</p>
                
                <p class="dropdown-label mb-0">Status</p>
                <select class="selectpicker mb-3" data-width="100%">
                    <option>Upcoming</option>
                    <option>Upcoming</option>
                    <option>Upcoming</option>
                </select>

                <p class="dropdown-label mb-0">Area</p>
                <select class="selectpicker mb-3" data-width="100%">
                    <option>America</option>
                    <option>America</option>
                    <option>America</option>
                </select>

                <p class="dropdown-label mb-0">Date</p>
                <div class="calendar mb-0"></div>
            </div>
        </div>

        <div class="col-xl-7 offset-xl-1 col-lg-8 right-order">
            <h2 class="mb-5">Overview of your orders</h2>

            <p class="card-title"><span>3</span> results are available</p>

            @foreach ($orders as $order)
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            @if ($order->status->code === 'completed')
                                <div class="col-md-auto green-box"></div>
                            @elseif ($order->status->code === 'cancelled')
                                <div class="col-md-auto red-box"></div>
                            @else
                                <div class="col-md-auto yellow-box"></div>
                            @endif
                            <div class="col-md-2 icao">{{ $order->search_result->search->start_airport->icao }}-{{ $order->search_result->search->end_airport->icao }}</div>
                            <div class="col-md-3 country">{{ $order->search_result->search->end_airport->country->name }}</div>
                            <div class="col-md-2 date">{{ $order->created_at->format('d/m/Y') }}</div>
                            <div class="col-md-2 price">EUR {{ number_format($order->price, 2, '.', ',') }}</div>
                            <div class="col-md-2 book">
                                <a href="{{ route('client.orders.booking', $order->id) }}" class="btn">Book now</a>
                            </div>
                            <div class="col-md-auto arrow">▼</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

