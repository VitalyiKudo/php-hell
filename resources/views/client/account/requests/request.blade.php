@extends('client.layouts.app')
@section('meta')
    <title>Requests | JetOnset</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTI9h361xswcSvVdM2kDtpiwcslXmjUYU&callback=initMap&libraries=&v=weekly" defer></script>

    <link href="{{ asset('css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet">

@endsection

@section('content')


<div class="container header-page-image"></div>


    <div class="section main-search-page">
        <div class="container">
            <div class="row">

                <div class="offset-md-1 col-md-8">


                    @if($lastSearchResults)
                    <nav aria-label="breadcrumb" class="row search-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><span class="search-title">Last searches:</span></li>
                            @foreach ($lastSearchResults as $lastSearch)
                            <li class="breadcrumb-item">
                                <a href="#" data-from="{{ $lastSearch->start_airport_name }}" data-to="{{ $lastSearch->end_airport_name }}">
                                    <span class="search-item-first">{{ $lastSearch->start_airport_name }}</span>
                                    <span class="search-item-second">{{ $lastSearch->end_airport_name }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ol>
                    </nav>
                    @endif

                    <form action="{{ route('client.search.index') }}" method="GET" id="main-search-form">

                        @csrf
                        <div class="row form-body mt-5">
                            <div class="col-lg-10 mb-2 mt-4 home-title">
                                <h1>Fly different today: Search your private jet</h1>
                            </div>
                            <div class="mb-3 mt-2 ml-3 start-point">
                                <div class="input-group input-style-3">
                                    <input type="text"
                                        class="form-control from"
                                        placeholder="Departure Airport"
                                        aria-describedby="departure-airport"
                                        name="startPoint"
                                        autocomplete="off"
                                        value="{{ $params['startPointName'] }}"
                                    >
                                    <div id="departureList"></div>
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="departure-airport">
                                        <img src="/images/departure-icon.svg" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-2 pl-0 bd end-point">
                                <div class="input-group input-style-2">
                                    <input type="text"
                                        class="form-control to"
                                        placeholder="Arrival Airport"
                                        aria-describedby="arrival-airport"
                                        name="endPoint"
                                        autocomplete="off"
                                        value="{{ $params['endPointnName'] }}"
                                    >
                                    <div id="arrivalList"></div>
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="arrival-airport">
                                        <img src="/images/arrival-icon.svg" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-2 ml-3 dt-field">
                                <div class="input-group input-style">
                                    <input type="text" class="form-control " name="flightDate" placeholder="Date&Time" autocomplete="off" value="{{ $params['flightDate'] }}">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="date-time">
                                        <img src="/images/date-icon.svg" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3 mt-2 pl-0 ml-3 pass-field">
                                <div class="input-group input-style">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bd-input" id="passengers" name="passengers" >
                                        <img src="/images/passengers-icon.svg" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                    <input type="number" min="1" class="form-control bd-input" placeholder="Passengers" aria-describedby="passengers" name="passengers" autocomplete="off" value="{{ $params['passengers'] }}">
                                </div>
                            </div>

                            <div class="form-container-1 mt-2 ml-3 butn-search">
                                <button type="submit" class="btn">Search Jet</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="container show-hide-map-wrapper mt-5 mb-3">
        <a href="#" id="show-hide-map"><span class="search-mark"></span> <span class="map-text">MAP OF YOUR FLIGHT</span> <span class="caret caret-down"></span></a>
    </div>


    <div class="section map-section">
        <div id="map"></div>
    </div>





    {{--<div class="container header-page-image"></div>--}}

    <div class="container request-search-page">



        <div class="row">

            {{--<div class="col-lg-2"></div>--}}

            <div class="col-xl-12 col-lg-12 right-request">
                <!--<h2 class="mb-5">Overview of your requests</h2>-->

                @if ($messages)
                    <div class="alert alert-danger">
                      <ul>
                          @foreach ($messages->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                    </div><br />
                @endif



                @if($searchResults and ($searchResults->price_turbo > 0 or $searchResults->price_light > 0 or $searchResults->price_medium > 0 or $searchResults->price_heavy > 0))

                    @if($searchResults->price_turbo > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-inner-image">

                                <div class="turbo-gallery-for">
                                    <div>
                                        <img src="/images/search_galery/turbo/TURBO-PROP.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/turbo/TURBO-PROP-1.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/turbo/TURBO-PROP-2.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/turbo/TURBO-PROP-3.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/turbo/TURBO-PROP-4.webp">
                                    </div>
                                </div>

                                <div class="turbo-gallery-nav">
                                    <div>
                                        <img src="/images/search_galery/turbo/TURBO-PROP.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/turbo/TURBO-PROP-1.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/turbo/TURBO-PROP-2.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/turbo/TURBO-PROP-3.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/turbo/TURBO-PROP-4.webp">
                                    </div>
                                </div>

                            </div>
                            <div class="card-inner-body pl-4">

                                <div class="type-price">
                                    <div>
                                        <span class="flight-type">Turbo</span>
                                        <span class="flight-dep-arr">{{ $searchResults->departure . ' - ' . $searchResults->arrival }}</span>
                                    </div>
                                    <div>
                                        <span class="flight-price">&#36;{{ number_format($searchResults->price_turbo, 2, '.', ' ') }}</span>
                                        <span class="flight-price-desc">Price (Incl. taxes)</span>
                                    </div>
                                </div>

                                <ul class="card-body-details">
                                    <li>
                                        <img src="/images/passagers.svg" alt="passagers">
                                        <div class="card-details-info">
                                            <span>{{ $params['passengers'] }}</span>
                                            <span>Passengers:</span>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="/images/time.svg" alt="time">
                                        <div class="card-details-info">
                                            <span>{{ $searchResults->time_turbo }}</span>
                                            <span>Flight Time:</span>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="/images/callender.svg" alt="callender">
                                        <div class="card-details-info">
                                            <span>{{ $params['flightDate'] }}</span>
                                            <span>Flight Date:</span>
                                        </div>
                                    </li>
                                </ul>

                                <div class="book">
                                    <a href="{{ route('client.orders.confirm', [$params['searchId'], 'turbo'] ) }}" class="btn book-now">Book now</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                    @if($searchResults->price_light > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-inner-image">

                                <div class="light-gallery-for">
                                    <div>
                                        <img src="/images/search_galery/light/LIGHT.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/light/LIGHT-1.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/light/LIGHT-2.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/light/LIGHT-3.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/light/LIGHT-4.webp">
                                    </div>
                                </div>

                                <div class="light-gallery-nav">
                                    <div>
                                        <img src="/images/search_galery/light/LIGHT.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/light/LIGHT-1.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/light/LIGHT-2.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/light/LIGHT-3.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/light/LIGHT-4.webp">
                                    </div>
                                </div>

                            </div>
                            <div class="card-inner-body">

                                <div class="type-price">
                                    <div>
                                        <span class="flight-type">Light</span>
                                        <span class="flight-dep-arr">{{ $searchResults->departure . ' - ' . $searchResults->arrival }}</span>
                                    </div>
                                    <div>
                                        <span class="flight-price">&#36;{{ number_format($searchResults->price_light, 2, '.', ' ') }}</span>
                                        <span class="flight-price-desc">Price (Incl. taxes)</span>
                                    </div>
                                </div>

                                <ul class="card-body-details">
                                    <li>
                                        <img src="/images/passagers.svg" alt="passagers">
                                        <div class="card-details-info">
                                            <span>{{ $params['passengers'] }}</span>
                                            <span>Passengers:</span>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="/images/time.svg" alt="time">
                                        <div class="card-details-info">
                                            <span>{{ $searchResults->time_light }}</span>
                                            <span>Flight Time:</span>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="/images/callender.svg" alt="callender">
                                        <div class="card-details-info">
                                            <span>{{ $params['flightDate'] }}</span>
                                            <span>Flight Date:</span>
                                        </div>
                                    </li>
                                </ul>

                                <div class="book">
                                    <a href="{{ route('client.orders.confirm', [$params['searchId'], 'light'] ) }}" class="btn book-now">Book now</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                    @if($searchResults->price_medium > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-inner-image">

                                <div class="medium-gallery-for">
                                    <div>
                                        <img src="/images/search_galery/medium/MIDSIZE.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/medium/MIDSIZE-1.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/medium/MIDSIZE-2.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/medium/MIDSIZE-3.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/medium/MIDSIZE-4.webp">
                                    </div>
                                </div>

                                <div class="medium-gallery-nav">
                                    <div>
                                        <img src="/images/search_galery/medium/MIDSIZE.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/medium/MIDSIZE-1.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/medium/MIDSIZE-2.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/medium/MIDSIZE-3.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/medium/MIDSIZE-4.webp">
                                    </div>
                                </div>

                            </div>
                            <div class="card-inner-body pl-4">

                                <div class="type-price">
                                    <div>
                                        <span class="flight-type">Medium</span>
                                        <span class="flight-dep-arr">{{ $searchResults->departure . ' - ' . $searchResults->arrival }}</span>
                                    </div>
                                    <div>
                                        <span class="flight-price">&#36;{{ number_format($searchResults->price_medium, 2, '.', ' ') }}</span>
                                        <span class="flight-price-desc">Price (Incl. taxes)</span>
                                    </div>
                                </div>

                                <ul class="card-body-details">
                                    <li>
                                        <img src="/images/passagers.svg" alt="passagers">
                                        <div class="card-details-info">
                                            <span>{{ $params['passengers'] }}</span>
                                            <span>Passengers:</span>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="/images/time.svg" alt="time">
                                        <div class="card-details-info">
                                            <span>{{ $searchResults->time_medium }}</span>
                                            <span>Flight Time:</span>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="/images/callender.svg" alt="callender">
                                        <div class="card-details-info">
                                            <span>{{ $params['flightDate'] }}</span>
                                            <span>Flight Date:</span>
                                        </div>
                                    </li>
                                </ul>

                                <div class="book">
                                    <a href="{{ route('client.orders.confirm', [$params['searchId'], 'medium'] ) }}" class="btn book-now">Book now</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                    @if($searchResults->price_heavy > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-inner-image">

                                <div class="heavy-gallery-for">
                                    <div>
                                        <img src="/images/search_galery/heavy/HEAVY.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/heavy/HEAVY-1.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/heavy/HEAVY-2.webp">
                                    </div>
                                    
                                    <div>
                                        <img src="/images/search_galery/heavy/HEAVY-3.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/heavy/HEAVY-4.webp">
                                    </div>
                                    
                                </div>

                                <div class="heavy-gallery-nav">
                                    <div>
                                        <img src="/images/search_galery/heavy/HEAVY.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/heavy/HEAVY-1.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/heavy/HEAVY-2.webp">
                                    </div>
                                    
                                    <div>
                                        <img src="/images/search_galery/heavy/HEAVY-3.webp">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/heavy/HEAVY-4.webp">
                                    </div>
                                    
                                </div>

                            </div>
                            <div class="card-inner-body pl-4">

                                <div class="type-price">
                                    <div>
                                        <span class="flight-type">Heavy</span>
                                        <span class="flight-dep-arr">{{ $searchResults->departure . ' - ' . $searchResults->arrival }}</span>
                                    </div>
                                    <div>
                                        <span class="flight-price">&#36;{{ number_format($searchResults->price_heavy, 2, '.', ' ') }}</span>
                                        <span class="flight-price-desc">Price (Incl. taxes)</span>
                                    </div>
                                </div>

                                <ul class="card-body-details">
                                    <li>
                                        <img src="/images/passagers.svg" alt="passagers">
                                        <div class="card-details-info">
                                            <span>{{ $params['passengers'] }}</span>
                                            <span>Passengers:</span>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="/images/time.svg" alt="time">
                                        <div class="card-details-info">
                                            <span>{{ $searchResults->time_heavy }}</span>
                                            <span>Flight Time:</span>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="/images/callender.svg" alt="callender">
                                        <div class="card-details-info">
                                            <span>{{ $params['flightDate'] }}</span>
                                            <span>Flight Date:</span>
                                        </div>
                                    </li>
                                </ul>

                                <div class="book">
                                    <a href="{{ route('client.orders.confirm', [$params['searchId'], 'heavy'] ) }}" class="btn book-now">Book now</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                @else

                    <p class="not-found-message">We do not have such a flight, make a request e quote</p>

                @endif

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-inner-image">
                            <img src="/images/search_galery/reqest_quote.png" class="img-fluid" alt="reqest quote">
                        </div>

                        <div class="card-inner-body pl-4">
                            <div class="custom-flight">
                                <div>Custom flight search</div>
                                <p>We would be more than happy to fulfill all of your special requests on our custom flight page.</p>
                            </div>
                            <form action="{{ route('client.search.requestQuote') }}" method="POST" id="request_quote">
                                @csrf

                                <div class="form-row">
                                    <div class="col">
                                        <label for="flight_model">Preferred aircraft:</label>
                                        <select name="flight_model" class="form-control" id="flight_model">
                                            <option value="">--- Nothing selected ---</option>
                                            <option value="turbo">Turbo</option>
                                            <option value="light">Light</option>
                                            <option value="medium">Medium</option>
                                            <option value="heavy">Heavy</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="comment">Comment</label>
                                        <textarea type="text" name="comment" class="form-control" id="comment"></textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="result_id" value="{{ $params['searchId'] }}" id="result_id">
                                <input type="hidden" name="user_id" value="{{ $params['userId'] }}" id="user_id">
                                <input type="hidden" name="start_airport_name" value="{{ $params['startPointName'] }}" id="start_airport_name">
                                <input type="hidden" name="end_airport_name" value="{{ $params['endPointnName'] }}" id="end_airport_name">
                                <input type="hidden" name="departure_at" value="{{ $params['flightDate'] }}" id="departure_at">
                                <input type="hidden" name="pax" value="{{ $params['passengers'] }}" id="pax">

                                <div class="text-right pull-right">
                                    <button type="submit" class="request-quote-submit pull-right">Request a Quote</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                <div class="pb-5"></div>

            </div>
        </div>
    </div>

<!--
<div class="container">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12">

                    <div class="row">

                        <div class="panel panel-default panel-horizontal">
                            <div class="panel-heading text-center" style="width:10em;">
                                <span><h3>3 weeks</h3></span>
                                <span>8 Febrero 2016</span>
                                <hr />
                                <div class="email" style="padding-top: 10px;">johndoe@tasktick.com</div>
                                <span><h5>2 weeks</h5><span>
                            </div>

                            <div class="panel-body">


                        <div class="col-xs-12 col-md-12 section-box">
                            <div class="email" style="padding-top: 10px;">johndoe@tasktick.com</div>
                            <h2>
                                Subject <a href="http://bootsnipp.com/" target="_blank"><span class="glyphicon glyphicon-new-window">
                                </span></a>
                            </h2>
                            <p>
                                Lorem ipsum dolor sit amet, eos ea prima ullamcorper. Epicurei efficiendi duo ex, ludus equidem epicuri id his, libris perfecto in usu. Lorem ipsum dolor sit amet, eos ea prima ullamcorper. Epicurei efficiendi duo ex, ludus equidem epicuri id his, libris perfecto in usu.
                            </p>
                            <hr />
                            <div class="row rating-desc">
                                <div class="col-md-12">
                                    <span class="glyphicon glyphicon-comment"></span>(100 Comments)<span class="separator">|</span>
                                </div>
                            </div>
                        </div>

                            </div>
                            <div class="panel-footer text-center" style="width:4em;">Actions</div>
                        </div>

                    </div>

            </div>
        </div>
    </div>
</div>
-->

<div class="hover_bkgr_fricc">
    <span class="helper"></span>
    <div>
        <div class="popupCloseButton">&times;</div>
        <p>Thank you!<br />We will send email soon.</p>
    </div>
</div>


@endsection


@push('scripts')

    <script src="{{ asset('js/slick.min.js') }}"></script>

    <script type="text/javascript">
        @if( isset($params['biggerLat']) && isset($params['biggerLng']) && isset($params['startCityLat']) && isset($params['startCityLng']) && isset($params['endCityLat']) && isset($params['endCityLng']) )
            function initMap() {
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 5,
                    center: { lat: {{ $params['biggerLat'] }}, lng: {{ $params['biggerLng'] }} },
                    mapTypeId: "terrain",
                });


                var LatLngList = new Array (new google.maps.LatLng ( {{ $params['startCityLat'] }}, {{ $params['startCityLng'] }}), new google.maps.LatLng ( {{ $params['endCityLat'] }}, {{ $params['endCityLng'] }} ));
                //  Create a new viewpoint bound
                var bounds = new google.maps.LatLngBounds ();
                //  Go through each...
                for (var i = 0, LtLgLen = LatLngList.length; i < LtLgLen; i++) {
                  //  And increase the bounds to take this point
                  bounds.extend (LatLngList[i]);
                }
                //  Fit these bounds to the map
                map.fitBounds(bounds);


                // Define a symbol using a predefined path (an arrow)
                // supplied by the Google Maps JavaScript API.
                const lineSymbol = {
                  path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
                };
                // Create the polyline and add the symbol via the 'icons' property.
                const line = new google.maps.Polyline({
                  path: [
                    { lat: {{ $params['startCityLat'] }}, lng: {{ $params['startCityLng'] }} },
                    { lat: {{ $params['endCityLat'] }}, lng: {{ $params['endCityLng'] }} }
                  ],
                  icons: [
                    {
                      icon: lineSymbol,
                      offset: "100%"
                    }
                  ],
                  map: map,
                  strokeColor: "#1479BF",
                  draggable: true,
                  geodesic: true,
                });
            }
        @endif


        $( "#show-hide-map" ).click(function(e) {
            e.preventDefault();
            if(parseFloat($(".map-section").height()) == 0){
                $("#show-hide-map").find('span.caret').removeClass('caret-down').addClass('caret-up');
                $( ".map-section" ).animate({
                    height: "500px",
                }, 300);
            }else{
                $("#show-hide-map").find('span.caret').removeClass('caret-up').addClass('caret-down');
                $( ".map-section" ).animate({
                    height: "0px",
                }, 300);
            }
        });


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

            $('input[name="flightDate"]').daterangepicker({
                opens: 'left',
                keepEmptyValues: true,
                singleDatePicker: true,
            });

            $('#request_quote').submit(function(e){
                e.preventDefault();
                var flight_model = $('#flight_model').val();
                var result_id = $('#result_id').val();
                var user_id = $('#user_id').val();
                var comment = $('#comment').val();
                var start_airport_name = $('#start_airport_name').val();
                var end_airport_name = $('#end_airport_name').val();
                var pax = $('#pax').val();
                var _token = $('input[name="_token"]').val();

                if(start_airport_name.length > 0 && end_airport_name.length > 0 && flight_model.length > 0){
                    $('#flight_model').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    $('.hover_bkgr_fricc').show();
                    $.ajax({
                        url: "{{ route('client.search.requestQuote') }}",
                        type:"POST",
                        data:{
                            _token:_token,
                            flight_model: flight_model,
                            result_id: result_id,
                            user_id: user_id,
                            comment: comment,
                            start_airport_name: start_airport_name,
                            end_airport_name: end_airport_name,
                            pax: pax
                        },
                        success:function(response){
                            console.log(response);
                        },
                    });
                } else {
                    $('#flight_model').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    $('#flight_model').addClass('is-invalid').parent('div').append('<span class="invalid-feedback"><strong>The Preferred aircraft: field is required.</strong></span>');
                }
            });


            $('input.from').keyup(function(){
                var query = $(this).val();

                if(query != '' && query.length >= 3){
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "/api/airports",
                        method: "GET",
                        data: {query:query, _token:_token},
                        success: function(data){
                            var lookup = {};
                            var output = '<ul class="dropdown-menu">';
                            $.each(data, function(idx, obj) {
                                if (obj.name.toLowerCase().includes(query.toLowerCase()) || obj.iata.toLowerCase().includes(query.toLowerCase())) {
                                    output += '<li><a href="' + obj.id + '">' + obj.name + '</a></li>';
                                } else {
                                    var city = obj.city;
                                    if (!(city in lookup)) {
                                        lookup[city] = 1;
                                        output += '<li><a href="' + obj.id + '">' + obj.city + '</a></li>';
                                    }
                                }
                            });
                            output += '</ul>';
                            $('#departureList').fadeIn();
                            $('#departureList').html(output);
                        }
                    });
                }
            });

            $(document).on('click', '#departureList li', function(e){
                e.preventDefault();
                $('input.from').val($(this).text());
                $('#departureList').fadeOut();
            });


            $('input.to').keyup(function(){
                var query = $(this).val();
                if(query != '' && query.length >= 3){
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "/api/airports",
                        method: "GET",
                        data: {query:query, _token:_token},
                        success: function(data){
                            var lookup = {};
                            var output = '<ul class="dropdown-menu">';
                            $.each(data, function(idx, obj) {
                                if (obj.name.toLowerCase().includes(query.toLowerCase()) || obj.iata.toLowerCase().includes(query.toLowerCase())) {
                                    output += '<li><a href="' + obj.id + '">' + obj.name + '</a></li>';
                                } else {
                                    var city = obj.city;
                                    if (!(city in lookup)) {
                                        lookup[city] = 1;
                                        output += '<li><a href="' + obj.id + '">' + obj.city + '</a></li>';
                                    }
                                }
                            });
                            output += '</ul>';
                            $('#arrivalList').fadeIn();
                            $('#arrivalList').html(output);
                        }
                    });
                }
            });

            $(document).on('click', '#arrivalList li', function(e){
                e.preventDefault();
                $('input.to').val($(this).text());
                $('#arrivalList').fadeOut();
            });

            $('.search-breadcrumb a').click(function(e){
                e.preventDefault();
                $('.form-body input[name="startPoint"]').val($(this).data("from"));
                $('.form-body input[name="endPoint"]').val($(this).data("to"));
            });




            $('#main-search-form').submit(function(e){

                var start_point = $(this).find('input[name="startPoint"]').val();
                var end_point = $(this).find('input[name="endPoint"]').val();
                var flight_date = $(this).find('input[name="flightDate"]').val();
                var passengers = $(this).find('input[name="passengers"]').val();
                var html_message = '<span class="search-error">This field is required.</span>';

                if(start_point.length <= 0 || end_point.length <= 0 || flight_date.length <= 0 || passengers.length <= 0){
                    $('.search-error').remove();

                    if(start_point.length <= 0){
                        $(this).find('input[name="startPoint"]').parent('div').append(html_message);
                    }
                    if(end_point.length <= 0){
                        $(this).find('input[name="endPoint"]').parent('div').append(html_message);
                    }
                    if(flight_date.length <= 0){
                        $(this).find('input[name="flightDate"]').parent('div').append(html_message);
                    }
                    if(passengers.length <= 0){
                        $(this).find('input[name="passengers"]').parent('div').append(html_message);
                    }
                    e.preventDefault();
                }
            });



        });
    </script>

@endpush
