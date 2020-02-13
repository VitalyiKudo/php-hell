@extends('client.layouts.app')
@section('meta')
    <title>Requests | JetOnset</title>
@endsection

@section('content')
    <div class="container header-page-image"></div>

    <div class="container request-page">
        <div class="row">
            <div class="col-lg-2">
{{--                <h2 class="mb-4 left-request-title">Requests</h2>--}}
{{--                <div class="left-request">--}}
{{--                    <p class="mb-3">Sort search request by</p>--}}

{{--                    <p class="dropdown-label mb-0">Status</p>--}}
{{--                    <select class="selectpicker mb-3" data-width="100%">--}}
{{--                        <option>Active</option>--}}
{{--                        <option>Active</option>--}}
{{--                        <option>Active</option>--}}
{{--                    </select>--}}

{{--                    <p class="dropdown-label mb-0">Area</p>--}}
{{--                    <select class="selectpicker mb-3" data-width="100%">--}}
{{--                        <option>America</option>--}}
{{--                        <option>America</option>--}}
{{--                        <option>America</option>--}}
{{--                    </select>--}}

{{--                    <p class="dropdown-label mb-0">Date</p>--}}
{{--                    <div class="calendar mb-0"></div>--}}
{{--                </div>--}}
            </div>

            <div class="col-xl-8 offset-xl-1 col-lg-8 right-request">
                <h2 class="mb-5">Overview of your requests</h2>

                <p class="card-title"><span>3</span> results are available</p>

                @foreach ($searchResults->data->results as $flight)

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">

                                <div class="col-md-auto green-box"></div>
{{--                                --}}
{{--                                <div class="col-md-auto red-box"></div>--}}

{{--                                <div class="col-md-auto yellow-box"></div>--}}

                                <div class="col-md-2 icao">
                                    {{ $flight->quote->segments[0]->startAirport->iata. '-'.$flight->quote->segments[0]->endAirport->iata }}</div>
                                <div class="col-md-3 country">RUSSIA</div>
                                <div class="col-md-2 date">
                                    {{ $flight->quote->segments[0]->departureDateTime->dateTimeUTC }}
                                </div>
                                <div class="col-md-2 price">
                                    {{ $flight->quote->sellerPriceWithoutCommission->currency .' '.$flight->quote->sellerPriceWithoutCommission->price }}
                                </div>
                                <div class="col-md-2 book">
                                    <a href="#" class="btn">Request again</a>
                                </div>
                                <div class="col-md-auto arrow">▼</div>
                            </div>
                        </div>
                    </div>
                    @if($loop->iteration == 15)
                        @break
                    @endif
                @endforeach

            </div>
        </div>
    </div>
@endsection

