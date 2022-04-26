@extends('client.layouts.app')
@section('meta')
    <title>Requests | JetOnset</title>
{{--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTI9h361xswcSvVdM2kDtpiwcslXmjUYU&callback=initMap&libraries=&v=weekly" defer></script> --}}

    <link href="{{ asset('css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet">

@endsection

@section('book_page', 'book-page-nav')

@section('content')
<div class="container header-page-image header-page-image-bg"></div>
    <div class="section main-search-page header-min-height">
        {{--<div class="container">
            <div class="row">

                <div class="offset-md-1 col-md-8">


{{--
                    <form action="{{ route('client.flight.index') }}" method="GET" id="main-search-form">

                        @csrf
                        <div class="row form-body form-search-mobile mt-5">
                            <div class="col-lg-10 mb-2 mt-4 home-title">
                                <h1>Fly different today: Search your private jet</h1>
                            </div>
                            <div class="mb-3 mt-2 ml-3 start-point">
                                <div class="input-group input-style-3">
                                    <input type="text"
                                        class="form-control from"
                                        placeholder="Departure Airport"
                                        aria-describedby="departure-airport"
                                        name="startPointName"
                                        autocomplete="off"
                                        value="{{ $params['startPointName'] }}"
                                    >
                                    <input type="hidden" name="startPoint" autocomplete="off" value="{{ $params['startPoint'] }}">
                                    <input type="hidden" name="startAirport" autocomplete="off" value="{{ $params['startAirport'] }}">
                                    <div id="departureList"></div>
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="departure-airport">
                                        <img src="{{ asset('images/departure-icon.svg') }}" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-2 pl-0 bd end-point">
                                <div class="input-group input-style-2">
                                    <input type="text"
                                        class="form-control to"
                                        placeholder="Arrival Airport"
                                        aria-describedby="arrival-airport"
                                        name="endPointName"
                                        autocomplete="off"
                                        value="{{ $params['endPointName'] }}"
                                    >
                                    <input type="hidden" name="endPoint" autocomplete="off" value="{{ $params['endPoint'] }}">
                                    <input type="hidden" name="endAirport" autocomplete="off" value="{{ $params['endAirport'] }}">
                                    <div id="arrivalList"></div>
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="arrival-airport">
                                        <img src="{{ asset('images/arrival-icon.svg') }}" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-2 ml-3 dt-field">
                                <div class="input-group input-style">
                                    <input type="text" class="form-control " name="flightDate" placeholder="Date&Time" autocomplete="off" value="{{ $params['flightDate'] }}">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="date-time">
                                        <img src="{{ asset('images/date-icon.svg') }}" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3 mt-2 pl-0 ml-3 pass-field">
                                <div class="input-group input-style">
                                    <input type="number" min="1" class="form-control bd-input" placeholder="Passengers" aria-describedby="passengers" name="passengers" autocomplete="off" value="{{ $params['passengers'] }}">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bd-input" id="passengers" name="passengers" >
                                        <img src="{{ asset('images/passengers-icon.svg') }}" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-container-1 mt-2 ml-3 butn-search">
                                <button type="submit" class="btn">Search Jet</button>
                            </div>
                        </div>
                    </form>
                    -}}
                </div>
            </div>
        </div>--}}
    </div>
{{--
    <div class="show-hide-map-outside-wrapper">
        <div class="container show-hide-map-wrapper mt-5 mb-3">
            <a href="#" id="show-hide-map"><span class="search-mark"></span> <span class="map-text">MAP OF YOUR FLIGHT</span> <span class="caret caret-down"></span></a>
        </div>
    </div>

    <div class="section map-section">
        <div id="map"></div>
    </div>
--}}
    {{--<div class="container header-page-image"></div>--}}

    <div class="container request-search-page">

        <div class="row">

            {{--<div class="col-lg-2"></div>--}}

            <div class="col-xl-12 col-lg-12 right-request">
                <!--<h2 class="mb-5">Overview of your requests</h2>-->
{{--
                @if ($messages)
                    <div class="alert alert-danger">
                      <ul>
                          @foreach ($messages->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                    </div><br />
                @endif
                --}}

                <form action="{{ route('client.search.requestQuote') }}" method="GET" id="request_empty_leg">
{{-- dd($emptyLegs) --}}
                    @forelse ($emptyLegs as $emptyLeg)
                        @php
                            $type = Str::after($emptyLeg->type_plane, '_');
                            $TYPE = Str::upper($type);
                            $Type = Str::ucfirst($type);
                        @endphp
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="card-inner-image">

                                            <div class="turbo-gallery-for">
                                                <div>
                                                    <img src="{{ asset("images/search_galery/$type/$TYPE.webp") }}" alt="{{$TYPE}}">
                                                </div>
                                                <div>
                                                    <img src="{{ asset("images/search_galery/$type/$TYPE-1.webp") }}" alt="{{$TYPE}}-1">
                                                </div>
                                                <div>
                                                    <img src="{{ asset("images/search_galery/$type/$TYPE-2.webp") }}" alt="{{$TYPE}}-2">
                                                </div>
                                                <div>
                                                    <img src="{{ asset("images/search_galery/$type/$TYPE-3.webp") }}" alt="{{$TYPE}}-3">
                                                </div>
                                                <div>
                                                    <img src="{{ asset("images/search_galery/$type/$TYPE-4.webp") }}" alt="{{$TYPE}}-4">
                                                </div>
                                            </div>

                                            <div class="turbo-gallery-nav">
                                                <div>
                                                    <img src="{{ asset("images/search_galery/$type/$TYPE.webp") }}" alt="{{$TYPE}}">
                                                </div>
                                                <div>
                                                    <img src="{{ asset("images/search_galery/$type/$TYPE-1.webp") }}" alt="{{$TYPE}}-1">
                                                </div>
                                                <div>
                                                    <img src="{{ asset("images/search_galery/$type/$TYPE-2.webp") }}" alt="{{$TYPE}}-2">
                                                </div>
                                                <div>
                                                    <img src="{{ asset("images/search_galery/$type/$TYPE-3.webp") }}" alt="{{$TYPE}}-3">
                                                </div>
                                                <div>
                                                    <img src="{{ asset("images/search_galery/$type/$TYPE-4.webp") }}" alt="{{$TYPE}}-4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-inner-body pl-4">

                                            <div class="type-price">
                                                <div>
                                                    <span class="flight-type">{{__("$Type")}}</span>
                                                    <span class="flight-dep-arr"><a href="/aircraft" title="{{__('ABOUT CLASS')}}">{{__('ABOUT CLASS')}}</a></span>
                                                </div>
                                                <div>
                                                    <span class="flight-price">{{ $emptyLeg->date_departure->format('d/m/Y') }}</span>
                                                    <span class="flight-price-desc text-right">{{__('Book now price')}}</span>
                                                </div>
                                            </div>

                                            <div class="type-info-legs">

                                                <span class="flight-price-desc">{{__('From Airport')}}</span>
                                                <span></span>
                                                <span class="flight-price-desc text-right">{{__('To Airport')}}</span>


                                                <span class="flight-price">{{ $emptyLeg->departureCity->name}}</span>
                                                <span></span>
                                                <span class="flight-price text-right">{{$emptyLeg->arrivalCity->name }}</span>

                                                  {{--<ul>
                                                      @foreach( Config::get("constants.plane.type_plane.$emptyLeg->type_plane.feature_plane") as $key => $value)
                                                        <li>
                                                            <img src="{{ asset(Config::get("constants.plane.icons.$key")) }}" alt="{{ $key }}">
                                                            <div class="card-details-info">
                                                                <span>{{ $value }}</span>
                                                                <span>{{ $key }}</span>
                                                            </div>
                                                        </li>
                                                      @endforeach
                                                  </ul>--}}
                                            </div>

                                            <div class="book" style="justify-content: space-between">
                                                {{--<button type="submit" class="btn rquest-best-price">{{__('Request for a best price')}}</button>--}}
                                                <div class="type-price-legs">
                                                    <div class="flight-price">&#36;{{ number_format($emptyLeg->price, 2, '.', ' ') }}</div>
                                                    <div class="flight-price-desc">{{__('Price (Incl. taxes)')}}</div>
                                                </div>
                                                <a href="{{ route('client.orders.confirm', ['test', $type] ) }}" class="btn book-now">{{__('Book now')}}</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                    @empty
                        <div></div>
                    @endforelse
{{--

                @if($searchResults->pricing and ($searchResults->pricing->price_turbo > 0 or $searchResults->pricing->price_light > 0 or $searchResults->pricing->price_medium > 0 or $searchResults->pricing->price_heavy > 0) and strtotime(date('m/d/Y',strtotime("+1 day"))) < strtotime($params['flightDate']))

                    @if($searchResults->pricing->price_turbo > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-inner-image">

                                <div class="turbo-gallery-for">
                                    <div>
                                        <img src="{{ asset('images/search_galery/turbo/TURBO-PROP.webp') }}" alt="TURBO-PROP">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/turbo/TURBO-PROP-1.webp') }}" alt="TURBO-PROP-1">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/turbo/TURBO-PROP-2.webp') }}" alt="TURBO-PROP-2">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/turbo/TURBO-PROP-3.webp') }}" alt="TURBO-PROP-3">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/turbo/TURBO-PROP-4.webp') }}" alt="TURBO-PROP-4">
                                    </div>
                                </div>

                                <div class="turbo-gallery-nav">
                                    <div>
                                        <img src="{{ asset('images/search_galery/turbo/TURBO-PROP.webp') }}" alt="TURBO-PROP">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/turbo/TURBO-PROP-1.webp') }}" alt="TURBO-PROP-1">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/turbo/TURBO-PROP-2.webp') }}" alt="TURBO-PROP-2">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/turbo/TURBO-PROP-3.webp') }}" alt="TURBO-PROP-3">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/turbo/TURBO-PROP-4.webp') }}" alt="TURBO-PROP-4">
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner-body pl-4">

                                <div class="type-price">
                                    <div>
                                        <span class="flight-type">Turbo</span>
                                        <span class="flight-dep-arr">{{ $searchResults->pricing->departure . ' - ' . $searchResults->pricing->arrival }}</span>
                                    </div>
                                    <div>
                                        <span class="flight-price">&#36;{{ number_format($searchResults->pricing->price_turbo, 2, '.', ' ') }}</span>
                                        <span class="flight-price-desc">Book now price</span>
                                    </div>
                                </div>

                                <div class="card-body-details">
                                    <ul>
                                        <li>
                                            <img src="{{ asset('images/passagers.svg') }}" alt="passagers">
                                            <div class="card-details-info">
                                                <span>1-12</span>
                                                <span>Passengers:</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/max_bags.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>28</span>
                                                <span>Cubic feet</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/altitude.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>30000ft</span>
                                                <span>Altitude</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/pilots.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>1-2</span>
                                                <span>Pilots</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/range.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>2500 miles</span>
                                                <span>Range</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/mas_speed.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>360 mph</span>
                                                <span>Max Speed</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/time.svg') }}" alt="time">
                                            <div class="card-details-info">
                                                <span>{{ $searchResults->pricing->time_turbo }}</span>
                                                <span>Flight Time: </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="book">
                                    <button type="submit" class="btn rquest-best-price">Request for a best price</button> <a href="{{ route('client.orders.confirm', [$params['searchId'], 'turbo'] ) }}" class="btn book-now">Book now</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                    @if($searchResults->pricing->price_light > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-inner-image">

                                <div class="light-gallery-for">
                                    <div>
                                        <img src="{{ asset('images/search_galery/light/LIGHT.webp') }}" alt="LIGHT">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/light/LIGHT-1.webp') }}" alt="LIGHT-1">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/light/LIGHT-2.webp') }}" alt="LIGHT-2">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/light/LIGHT-3.webp') }}" alt="LIGHT-3">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/light/LIGHT-4.webp') }}" alt="LIGHT-4">
                                    </div>
                                </div>

                                <div class="light-gallery-nav">
                                    <div>
                                        <img src="{{ asset('images/search_galery/light/LIGHT.webp') }}" alt="LIGHT">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/light/LIGHT-1.webp') }}" alt="LIGHT-1">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/light/LIGHT-2.webp') }}" alt="LIGHT-2">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/light/LIGHT-3.webp') }}" alt="LIGHT-3">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/light/LIGHT-4.webp') }}" alt="LIGHT-4">
                                    </div>
                                </div>

                            </div>
                            <div class="card-inner-body">

                                <div class="type-price">
                                    <div>
                                        <span class="flight-type">Light</span>
                                        <span class="flight-dep-arr">{{ $searchResults->pricing->departure . ' - ' . $searchResults->pricing->arrival }}</span>
                                    </div>
                                    <div>
                                        <span class="flight-price">&#36;{{ number_format($searchResults->pricing->price_light, 2, '.', ' ') }}</span>
                                        <span class="flight-price-desc">Book now price</span>
                                    </div>
                                </div>

                                <div class="card-body-details">
                                    <ul>
                                        <li>
                                            <img src="{{ asset('images/passagers.svg') }}" alt="passagers">
                                            <div class="card-details-info">
                                                <span>1-8</span>
                                                <span>Passengers:</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/max_bags.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>45</span>
                                                <span>Cubic feet</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/altitude.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>37,000ft</span>
                                                <span>Altitude</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/pilots.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>2</span>
                                                <span>Pilots</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/range.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>3700 miles</span>
                                                <span>Range</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/mas_speed.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>534 mph</span>
                                                <span>Max Speed</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/time.svg') }}" alt="time">
                                            <div class="card-details-info">
                                                <span>{{ $searchResults->pricing->time_light }}</span>
                                                <span>Flight Time: </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                 <div class="book">
                                    <button type="submit" class="btn rquest-best-price">Request for a best price</button> <a href="{{ route('client.orders.confirm', [$params['searchId'], 'light'] ) }}" class="btn book-now">Book now</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                    @if($searchResults->pricing->price_medium > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-inner-image">

                                <div class="medium-gallery-for">
                                    <div>
                                        <img src="{{ asset('images/search_galery/medium/MIDSIZE.webp') }}" alt="MIDSIZE">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/medium/MIDSIZE-1.webp') }}" alt="MIDSIZE-1">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/medium/MIDSIZE-2.webp') }}" alt="MIDSIZE-2">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/medium/MIDSIZE-3.webp') }}" alt="MIDSIZE-3">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/medium/MIDSIZE-4.webp') }}" alt="MIDSIZE-4">
                                    </div>
                                </div>

                                <div class="medium-gallery-nav">
                                    <div>
                                        <img src="{{ asset('images/search_galery/medium/MIDSIZE.webp') }}" alt="MIDSIZE">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/medium/MIDSIZE-1.webp') }}" alt="MIDSIZE-1">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/medium/MIDSIZE-2.webp') }}" alt="MIDSIZE-2">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/medium/MIDSIZE-3.webp') }}" alt="MIDSIZE-3">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/medium/MIDSIZE-4.webp') }}" alt="MIDSIZE-4">
                                    </div>
                                </div>

                            </div>
                            <div class="card-inner-body pl-4">

                                <div class="type-price">
                                    <div>
                                        <span class="flight-type">Medium</span>
                                        <span class="flight-dep-arr">{{ $searchResults->pricing->departure . ' - ' . $searchResults->pricing->arrival }}</span>
                                    </div>
                                    <div>
                                        <span class="flight-price">&#36;{{ number_format($searchResults->pricing->price_medium, 2, '.', ' ') }}</span>
                                        <span class="flight-price-desc">Book now price</span>
                                    </div>
                                </div>

                                <div class="card-body-details">
                                    <ul>
                                        <li>
                                            <img src="{{ asset('images/passagers.svg') }}" alt="passagers">
                                            <div class="card-details-info">
                                                <span>1-11</span>
                                                <span>Passengers:</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/max_bags.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>125</span>
                                                <span>Cubic feet</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/altitude.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>51,000ft</span>
                                                <span>Altitude</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/pilots.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>2</span>
                                                <span>Pilots</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/range.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>4000 miles</span>
                                                <span>Range</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/mas_speed.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>603 mph</span>
                                                <span>Max Speed</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/time.svg') }}" alt="time">
                                            <div class="card-details-info">
                                                <span>{{ $searchResults->pricing->time_medium }}</span>
                                                <span>Flight Time: </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="book">
                                    <button type="submit" class="btn rquest-best-price">Request for a best price</button> <a href="{{ route('client.orders.confirm', [$params['searchId'], 'medium'] ) }}" class="btn book-now">Book now</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                    @if($searchResults->pricing->price_heavy > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-inner-image">

                                <div class="heavy-gallery-for">
                                    <div>
                                        <img src="{{ asset('images/search_galery/heavy/HEAVY.webp') }}" alt="HEAVY">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/heavy/HEAVY-1.webp') }}" alt="HEAVY-1">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/heavy/HEAVY-2.webp') }}" alt="HEAVY-2">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/heavy/HEAVY-3.webp') }}" alt="HEAVY-3">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/heavy/HEAVY-4.webp') }}" alt="HEAVY-4">
                                    </div>

                                </div>

                                <div class="heavy-gallery-nav">
                                    <div>
                                        <img src="{{ asset('images/search_galery/heavy/HEAVY.webp') }}" alt="HEAVY">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/heavy/HEAVY-1.webp') }}" alt="HEAVY-1">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/heavy/HEAVY-2.webp') }}" alt="HEAVY-2">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/heavy/HEAVY-3.webp') }}" alt="HEAVY-3">
                                    </div>
                                    <div>
                                        <img src="{{ asset('images/search_galery/heavy/HEAVY-4.webp') }}" alt="HEAVY-4">
                                    </div>

                                </div>

                            </div>
                            <div class="card-inner-body pl-4">

                                <div class="type-price">
                                    <div>
                                        <span class="flight-type">Heavy</span>
                                        <span class="flight-dep-arr">{{ $searchResults->pricing->departure . ' - ' . $searchResults->pricing->arrival }}</span>
                                    </div>
                                    <div>
                                        <span class="flight-price">&#36;{{ number_format($searchResults->pricing->price_heavy, 2, '.', ' ') }}</span>
                                        <span class="flight-price-desc">Book now price</span>
                                    </div>
                                </div>


                                <div class="card-body-details">
                                    <ul>
                                        <li>
                                            <img src="{{ asset('images/passagers.svg') }}" alt="passagers">
                                            <div class="card-details-info">
                                                <span>1-16</span>
                                                <span>Passengers:</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/max_bags.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>226</span>
                                                <span>Cubic feet</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/altitude.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>41,000ft</span>
                                                <span>Altitude</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/pilots.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>2</span>
                                                <span>Pilots</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/range.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>8000 miles</span>
                                                <span>Range</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/mas_speed.svg') }}" alt="callender">
                                            <div class="card-details-info">
                                                <span>562 mph</span>
                                                <span>Max Speed</span>
                                            </div>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/time.svg') }}" alt="time">
                                            <div class="card-details-info">
                                                <span>{{ $searchResults->pricing->time_heavy }}</span>
                                                <span>Flight Time: </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="book">
                                    <button type="submit" class="btn rquest-best-price">Request for a best price</button> <a href="{{ route('client.orders.confirm', [$params['searchId'], 'heavy'] ) }}" class="btn book-now">Book now</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                @else

                    <p class="not-found-message">We do not have such a flight, make a request a quote </p>

                @endif

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-inner-image">
                            <img src="{{ asset('images/search_galery/reqest_quote.png') }}" class="img-fluid" alt="reqest quote">
                        </div>

                        <div class="card-inner-body pl-4">
                            <div class="custom-flight">
                                <div>Custom flight search</div>
                           <p>We would be more than happy to fulfill all of your special requests on our custom flight page.</p>
                       </div>
                       <!--<form action="{{ route('client.search.requestQuote') }}" method="GET" id="request_quote">-->
                           @csrf

                           <div class="form-row">
                               <div class="form-group col-sm-6">
                                   <label for="flight_model">Flight model:</label>
                                   <select name="flight_model" class="form-control" id="flight_model">
                                       <option value="">--- Nothing selected ---</option>
                                       <option value="turbo">Turbo</option>
                                       <option value="light">Light</option>
                                       <option value="medium">Medium</option>
                                       <option value="heavy">Heavy</option>
                                   </select>
                               </div>

                               <div class="form-group col-sm-3">
                                   <label for="passengers">Passengers</label>
                                   <input type="number" min="1" aria-describedby="pax" name="pax" autocomplete="off" value="{{ $params['passengers'] }}" id="passengers" class="form-control">
                               </div>

                               <div class="form-group col-sm-3">
                                   <label for="bags">Bags</label>
                                   <input type="number" min="1" aria-describedby="bags" name="bags" autocomplete="off" id="bags" class="form-control">
                               </div>

                               <!--
                               <div class="form-group col-sm-6">
                                   <label for="comment">Comment</label>
                                   <textarea type="text" name="comment" class="form-control" id="comment"></textarea>
                               </div>
                               -->
                           </div>

                           <input type="hidden" name="result_id" value="{{ $params['searchId'] }}" id="result_id">
                           <input type="hidden" name="user_id" value="{{ $params['userId'] }}" id="user_id">
                           <input type="hidden" name="startPointName" value="{{ $params['startPointName'] }}" id="start_airport_name">
                           <input type="hidden" name="endPointName" value="{{ $params['endPointName'] }}" id="end_airport_name">
                            <input type="hidden" name="startPoint" value="{{ $params['startPoint'] }}" id="start_city_id">
                            <input type="hidden" name="endPoint" value="{{ $params['endPoint'] }}" id="end_city_id">
                            <input type="hidden" name="startAirport" value="{{ $params['startAirport'] }}" id="start_airport_id">
                            <input type="hidden" name="endAirport" value="{{ $params['endAirport'] }}" id="end_airport_id">
                           <input type="hidden" name="departure_at" value="{{ $params['flightDate'] }}" id="departure_at">
                           <!--<input type="hidden" name="pax" value="{{ $params['passengers'] }}" id="pax">-->
                           <input type="hidden" name="page_name" value="search-page">

                           <div class="text-right pull-right">
                               <button type="submit" class="request-quote-submit pull-right">Request a Quote</button>
                           </div>
                       <!--</form>-->
                   </div>

               </div>
           </div>


--}}
           </form>



           <div class="pb-5"></div>

       </div>
   </div>
</div>

<div class="hover_bkgr_fricc">
<span class="helper"></span>
<div>
   <div class="popupCloseButton">&times;</div>
   <p>Thank you!<br />We will send email soon.</p>
</div>
</div>

<div class="modal fade" id="T-C" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms&Conditions</h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script type="text/javascript">



        $(function() {

            $('.turbo-gallery-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                dots: false,
                asNavFor: '.turbo-gallery-nav',
                autoplay: false,
                adaptiveHeight: true,
            });

            $('.turbo-gallery-nav').slick({
                slidesToShow: 5,
                slidesToScroll: 5,
                asNavFor: '.turbo-gallery-for',
                dots: false,
                centerMode: true,
                centerPadding: '130px',
                focusOnSelect: true,
                arrows: false,
                autoplay: false,
            });

            $('.turbo-gallery-for').on('click', '.slick-arrow', function(){
                $('.slick-track').css({'transform': 'translate3d(0px, 0px, 0px)'});
            });


            $('.light-gallery-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                dots: false,
                asNavFor: '.light-gallery-nav',
                autoplay: false,
                adaptiveHeight: true,
            });

            $('.light-gallery-nav').slick({
                slidesToShow: 5,
                slidesToScroll: 5,
                asNavFor: '.light-gallery-for',
                dots: false,
                centerMode: true,
                centerPadding: '130px',
                focusOnSelect: true,
                arrows: false,
                autoplay: false,
            });

            $('.light-gallery-for').on('click', '.slick-arrow', function(){
                $('.slick-track').css({'transform': 'translate3d(0px, 0px, 0px)'});
            });


            $('.medium-gallery-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                dots: false,
                asNavFor: '.medium-gallery-nav',
                autoplay: false,
                adaptiveHeight: true,
            });

            $('.medium-gallery-nav').slick({
                slidesToShow: 5,
                slidesToScroll: 5,
                asNavFor: '.medium-gallery-for',
                dots: false,
                centerMode: true,
                centerPadding: '130px',
                focusOnSelect: true,
                arrows: false,
                autoplay: false,
            });

            $('.medium-gallery-for').on('click', '.slick-arrow', function(){
                $('.slick-track').css({'transform': 'translate3d(0px, 0px, 0px)'});
            });


            $('.heavy-gallery-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                dots: false,
                asNavFor: '.heavy-gallery-nav',
                autoplay: false,
                adaptiveHeight: true,
            });

            $('.heavy-gallery-nav').slick({
                slidesToShow: 5,
                slidesToScroll: 5,
                asNavFor: '.heavy-gallery-for',
                dots: false,
                centerMode: true,
                centerPadding: '130px',
                focusOnSelect: true,
                arrows: false,
                autoplay: false,
            });

            $('.heavy-gallery-for').on('click', '.slick-arrow', function(){
                $('.slick-track').css({'transform': 'translate3d(0px, 0px, 0px)'});
            });


            $('.hover_bkgr_fricc').click(function(){
                $('.hover_bkgr_fricc').hide();
            });
            $('.popupCloseButton').click(function(){
                $('.hover_bkgr_fricc').hide();
            });


            var tc = '{{$status}}';
            if (tc === 'notAge') {
                $('.modal-body').append('<p>If you are under 18 years old you cannot make an order.</p><p>We apologize for inconvenience.</p>');
                $('.rquest-best-price').attr('disabled', true);
                $('.book a').removeClass('book-now').addClass('rquest-best-price').click(function(e){
                    e.preventDefault();
                    $('#T-C').modal('show');
                });
                $('#T-C').modal('show');
            }
            else if (tc === 'notFilledAge') {
                $('.modal-body').append('<p>Please fill up your date of birth in the profile.</p>');
                $('.rquest-best-price').attr('disabled', true);
                $('.book a').removeClass('book-now').addClass('rquest-best-price').click(function (e) {
                    e.preventDefault();
                    $('#T-C').modal('show');
                });
                $('#T-C').modal('show');
            };
            /*  else if (tc === 'notAuthorized') {
              $('.modal-body').append('<p>Не Авторизован!</p>');
              $('.rquest-best-price').attr('disabled', true);
              $('.book a').removeClass('book-now').addClass('rquest-best-price').click(function(e){
                  e.preventDefault();
                  $('#T-C').modal('show');
              });
              $('#T-C').modal('show');
          };*/

        });
    </script>

@endpush
