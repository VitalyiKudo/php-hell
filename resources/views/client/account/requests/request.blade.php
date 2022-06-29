@extends('client.layouts.app')
@section('meta')
    <title>Requests | JetOnset</title>
    <!--script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTI9h361xswcSvVdM2kDtpiwcslXmjUYU&callback=initMap&libraries=&v=weekly" defer></script-->

    <link href="{{ asset('css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet">

@endsection

@section('book_page', 'book-page-nav')

@section('content')
<div class="container header-page-image header-page-image-bg"></div>
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
                                    <a href="#" data-from="{{ $lastSearch->departureCity->name }}" data-to="{{ $lastSearch->arrivalCity->name }}">
                                        <span class="search-item-first">{{ $lastSearch->departureCity->name }}</span>
                                        <span class="search-item-second">{{ $lastSearch->arrivalCity->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                    @elseif ($lastSessionSearchResults)
                    <nav aria-label="breadcrumb" class="row search-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><span class="search-title">Last searches:</span></li>
                            @foreach ($lastSessionSearchResults as $lastSessionSearch)
                            <li class="breadcrumb-item">
                                <a href="#" data-from="{{ $lastSessionSearch['start_airport_name'] }}" data-to="{{ $lastSessionSearch['end_airport_name'] }}">
                                    <span class="search-item-first">{{ $lastSessionSearch['start_airport_name'] }}</span>
                                    <span class="search-item-second">{{ $lastSessionSearch['end_airport_name'] }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ol>
                    </nav>
                    @endif

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
                                <button type="submit" class="btn">Find a Jet</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="show-hide-map-outside-wrapper">
        <div class="container show-hide-map-wrapper mt-5 mb-3">
            <a href="#" id="show-hide-map"><span class="search-mark"></span> <span class="map-text">MAP OF YOUR FLIGHT</span> <span class="caret caret-down"></span></a>
        </div>
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
                    @forelse ($searchResults as $key => $emptyLeg)
                    {{-- dd($emptyLeg) --}}
                    @if(empty($emptyLeg['pricing']))
                        {!! ((int)$emptyLeg->price !== 0) ?
                        "<form action='" . route('client.orders.confirm') . "' method='GET'>"
                        :
                        "<form action='" . route('client.search.requestQuote') . "' method='GET'>"
                        !!}
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
                                                        <span class="flight-dep-arr">{{ $emptyLeg->departureCity->name . ' - ' . $emptyLeg->arrivalCity->name }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="flight-price">&#36;{{ number_format($emptyLeg->price, 2, '.', ' ') }}</span>
                                                        <span class="flight-price-desc">{{__('Book now price')}}</span>
                                                    </div>
                                                </div>

                                                <div class="card-body-details">
                                                      <ul>
                                                          @foreach( Config::get("constants.plane.type_plane.$emptyLeg->type_plane.feature_plane") as $key => $value)
                                                            <li>
                                                                <img src="{{ asset(Config::get("constants.plane.icons.$key")) }}" alt="{{ $key }}">
                                                                <div class="card-details-info">
                                                                    <span>{{ $value }}</span>
                                                                    <span>{{ $key }}</span>
                                                                </div>
                                                            </li>
                                                          @endforeach
                                                      </ul>
                                                </div>


                                                <input type="hidden" name="result_id" value="{{ $emptyLeg->id }}">
                                                <input type="hidden" name="aircraft" value="{{ $Type }}">
                                                <input type="hidden" name="startPointName" value="{{ $emptyLeg->departureCity->name }}">
                                                <input type="hidden" name="endPointName" value="{{ $emptyLeg->arrivalCity->name }}">
                                                <input type="hidden" name="startPoint" value="{{ $emptyLeg->departureCity->geonameid }}">
                                                <input type="hidden" name="endPoint" value="{{ $emptyLeg->arrivalCity->geonameid }}">
                                                <input type="hidden" name="startAirport" value="{{ $emptyLeg->airportDeparture->icao }}">
                                                <input type="hidden" name="endAirport" value="{{ $emptyLeg->airportArrival->icao }}">
                                                <input type="hidden" name="departure_at" value="{{ $emptyLeg->date_departure }}">
                                                <input type="hidden" name="price" value="{{ $emptyLeg->price }}">
                                                <input type="hidden" name="type" value="emptyLeg">
                                                <input type="hidden" name="page_name" value="reqest-emptyLeg-page">

                                                {!! ((int)$emptyLeg->price !== 0) ?
                                                "<div class='book'>
                                                    <button type='submit' class='btn rquest-best-price'>" . __('Request for a best price') . "</button>
                                                    <button type='submit' class='book btn book-now'>" . __('Book now') . "</button>
                                                </div>"
                                                :
                                                "<div class='book'>
                                                    <button type='submit' class='request-empty-leg-submit'>" . __('Request a Quote') . "</button>
                                                </div>"
                                                !!}
                                            </div>
                                        </div>
                                    </div>
                        {!! "</form>" !!}
                    @endif
                    @empty
                        <div></div>
                    @endforelse

                    @forelse ($searchResults as $key => $value)
                        @if(isset($value['pricing']))
                            @php
                                $type = $value['type'];
                                $TYPE = Str::upper($type);
                                $Type = Str::ucfirst($type);
                            @endphp
                            @if($type !== 'quote')
                                @if($countPricing > 1)
                                    <form action='{{ route('client.orders.confirm') }}' method='GET'>
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
                                                            <span class="flight-dep-arr">{{ $value['startCity'] . ' - ' . $value['endtCity'] }}</span>
                                                        </div>
                                                        <div>
                                                            <span class="flight-price">&#36;{{ number_format($value['price'] , 2, '.', ' ') }}</span>
                                                            <span class="flight-price-desc">{{__('Book now price')}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="card-body-details">
                                                        <ul>
                                                            @foreach( Config::get("constants.plane.type_plane.plane_$type.feature_plane") as $key => $val)
                                                                <li>
                                                                    <img src="{{ asset(Config::get("constants.plane.icons.$key")) }}" alt="{{ $key }}">
                                                                    {{-- print "$key - $$value" --}}
                                                                    <div class="card-details-info">
                                                                        <span>{{ ($key === 'Flight Time') ? $value['time'] : $val }}</span>
                                                                        <span>{{ $key }}</span>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                    <input type="hidden" name="result_id" value="0">
                                                    <input type="hidden" name="aircraft" value="{{ $type }}">
                                                    <input type="hidden" name="startPointName" value="{{ $params['startPointName'] }}">
                                                    <input type="hidden" name="endPointName" value="{{ $params['endPointName'] }}">
                                                    <input type="hidden" name="startPoint" value="{{ $params['startPoint'] }}">
                                                    <input type="hidden" name="endPoint" value="{{ $params['endPoint'] }}">
                                                    <input type="hidden" name="startAirport" value="{{ $params['startAirport'] }}">
                                                    <input type="hidden" name="endAirport" value="{{ $params['endAirport'] }}">
                                                    <input type="hidden" name="departure_at" value="{{ $params['flightDate'] }}">
                                                    <input type="hidden" name="passengers" value="{{ $params['passengers'] }}">

                                                    <input type="hidden" name="type" value="{{ $type }}">
                                                    <input type="hidden" name="page_name" value="reqest-search-page">

                                                      <div class='book'>
                                                          <button type='submit' class='btn rquest-best-price'>{{ __('Request for a best price') }}</button>
                                                          <button type='submit' class='book btn book-now'>{{ __('Book now') }}</button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </form>
                                  @else
                                      <p class="not-found-message">We do not have such a flight, make a request a quote </p>
                                  @endif
                              @else
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
                                              <form action="{{ route('client.search.requestQuote') }}" method="GET" id="request_quote">
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

                                                  {{--<input type="hidden" name="result_id" value="{{ $params['searchId'] }}" id="result_id">--}}
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
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        @endif
                    @empty
                        <div></div>
                    @endforelse

                <div class="d-flex justify-content-center">
                    {!! $searchResults->appends($_GET)->links() !!}
                </div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>
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

       var nowDate = new Date();
       var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
       $('input[name="flightDate"]').daterangepicker({
           opens: 'left',
           keepEmptyValues: true,
           singleDatePicker: true,
           autoUpdateInput: true,
           isInvalidDate: (e) => new Date(e) < today
       });

       /*
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
                       //$('.hover_bkgr_fricc').show();
                       console.log(response);
                   },
               });
           } else {
               $('#flight_model').removeClass('is-invalid');
               $('.invalid-feedback').remove();
               $('#flight_model').addClass('is-invalid').parent('div').append('<span class="invalid-feedback"><strong>The Preferred aircraft: field is required.</strong></span>');
           }

       });
       */

       /*
       $('#request_quote').submit(function(e){
           var flight_model = $('#flight_model').val();
           if(flight_model.length <= 0){
               e.preventDefault();
               $('#flight_model').removeClass('is-invalid');
               $('.invalid-feedback').remove();
               $('#flight_model').addClass('is-invalid').parent('div').append('<span class="invalid-feedback"><strong>The Preferred aircraft: field is required.</strong></span>');
           }
       });
       */

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
                       function removeDuplicatesBy(keyFn, array) {
                           var mySet = new Set();
                           return array.filter(function(x) {
                               var key = keyFn(x), isNew = !mySet.has(key);
                               if (isNew) mySet.add(key);
                               return isNew;
                           });
                       }

                       var withoutDuplicates = removeDuplicatesBy(x => x.name, data);

                       if (data.length !== 0){
                           $.each(data, function(idx, obj) {
                               var city = (!$.isEmptyObject(obj.city)) ? obj.city : '';
                               var region = (!$.isEmptyObject(obj.region)) ? obj.region + ', ' : '';
                               var country = (!$.isEmptyObject(obj.country)) ? obj.country : '';
                               var objAirport = obj.airport;

                               output += '<div>' + '<span>' + city + '</span><span>' + region + country + '</span>' + '</div>';

                               $.each(objAirport, function(k, val) {
                                   var iata = (!$.isEmptyObject(val.iata)) ? '(' + val.iata + ')': '';
                                   output += '<li><a href="' + obj.id + '">' +
                                       '<div>'+ '<span>'+ val.name +'</span>' + '<span><icao>' + val.icao + '</icao>' + iata + '</span>' + '</div>' +
                                       '</a></li>';
                               });

                           });
                       }
                       else {
                           output += '<li>No matches found</li>';
                       }
                       output += '</ul>';
                       $('#departureList').fadeIn();
                       $('#departureList').html(output).mark(query);
                   }
               });
           }
       });

       $(document).on('click', '#departureList li', function(e){
           e.preventDefault();
           $('input.from').val($(this).find('span:first').text());
           $('input[name="startPoint"]').val($(this).find('a:first').attr('href'));
           $('input[name="startAirport"]').val($(this).find('icao:first').text());
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
                       function removeDuplicatesBy(keyFn, array) {
                           var mySet = new Set();
                           return array.filter(function(x) {
                               var key = keyFn(x), isNew = !mySet.has(key);
                               if (isNew) mySet.add(key);
                               return isNew;
                           });
                       }

                       var withoutDuplicates = removeDuplicatesBy(x => x.name, data);

                       if (data.length !== 0){
                           $.each(data, function(idx, obj) {
                               var city = (!$.isEmptyObject(obj.city)) ? obj.city : '';
                               var region = (!$.isEmptyObject(obj.region)) ? obj.region + ', ' : '';
                               var country = (!$.isEmptyObject(obj.country)) ? obj.country : '';
                               var objAirport = obj.airport;

                               output += '<div>' + '<span>' + city + '</span><span>' + region + country + '</span>' + '</div>';

                               $.each(objAirport, function(k, val) {
                                   var iata = (!$.isEmptyObject(val.iata)) ? '(' + val.iata + ')': '';
                                   output += '<li><a href="' + obj.id + '">' +
                                       '<div>'+ '<span>'+ val.name +'</span>' + '<span><icao>' + val.icao + '</icao>' + iata + '</span>' + '</div>' +
                                       '</a></li>';
                               });

                           });
                       }
                       else {
                           output += '<li>No matches found</li>';
                       }
                       output += '</ul>';
                       $('#arrivalList').fadeIn();
                       $('#arrivalList').html(output).mark(query);
                   }
               });
           }
       });

       $(document).on('click', '#arrivalList li', function(e){
           e.preventDefault();
           $('input.to').val($(this).find('span:first').text());
           $('input[name="endPoint"]').val($(this).find('a:first').attr('href'));
           $('input[name="endAirport"]').val($(this).find('icao:first').text());
           $('#arrivalList').fadeOut();
       });

       $('.search-breadcrumb a').click(function(e){
           e.preventDefault();
           $('.form-body input[name="startPointName"]').val($(this).data("from"));
           $('.form-body input[name="endPointName"]').val($(this).data("to"));
       });


       $('body').on('click', function(){
           $('#departureList').fadeOut();
           $('#arrivalList').fadeOut();
       });


       $('#main-search-form').submit(function(e){

           var start_point_id = $(this).find('input[name="startPoint"]').val();
           var end_point_id = $(this).find('input[name="endPoint"]').val();
           var start_point_name = $(this).find('input[name="startPointName"]').val();
           var end_point_name = $(this).find('input[name="endPointName"]').val();
           var flight_date = $(this).find('input[name="flightDate"]').val();
           var passengers = $(this).find('input[name="passengers"]').val();
           var html_message = '<span class="search-error">This field is required.</span>';

           if(start_point_name.length <= 0 || end_point_name.length <= 0 || flight_date.length <= 0 || passengers.length <= 0){
               $('.search-error').remove();

               if(start_point.length <= 0){
                   $(this).find('input[name="startPointName"]').parent('div').append(html_message);
               }
               if(end_point.length <= 0){
                   $(this).find('input[name="endPointName"]').parent('div').append(html_message);
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
