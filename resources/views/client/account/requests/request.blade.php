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

                    <form action="{{ route('client.search.index') }}" method="GET">
                        @csrf
                        <div class="row form-body mt-5">
                            <div class="col-lg-10">
                                <h4 class="mb-3 mt-4">Fly different today: Search your private jet</h4>
                            </div>
                            <div class="mb-3 mt-2 ml-3" style="width:23% !important">
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
                            <div class="mb-3 mt-2 pl-0 bd" style="width: 23% !important">
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
                            <div class="mb-3 mt-2 ml-3" style="width: 19% !important">
                                <div class="input-group input-style">
                                    <input type="text" class="form-control " name="flightDate" placeholder="Date&Time" autocomplete="off" value="{{ $params['flightDate'] }}">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="date-time">
                                        <img src="/images/date-icon.svg" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3 mt-2 pl-0 ml-3" style="width:16% !important">
                                <div class="input-group input-style">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bd-input" id="passengers" name="passengers" >
                                        <img src="/images/passengers-icon.svg" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                    <input type="number" min="0" class="form-control bd-input" placeholder="Passengers" aria-describedby="passengers" name="passengers" autocomplete="off" value="{{ $params['passengers'] }}">
                                </div>
                            </div>

                            <div class="form-container-1 mt-2 ml-3" style="width:11% !important">
                                <button type="submit" class="btn">Search Jet</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div class="section show-hide-map-wrapper mt-5 mb-3">
        <a href="#" id="show-hide-map"><span class="caret caret-down"></span> <span class="map-text">MAPS OF YOUR ROUTE</span> <span class="caret caret-down"></span></a>
    </div>


    <div class="section map-section">
        <div id="map"></div>
    </div>
    
    



    {{--<div class="container header-page-image"></div>--}}

    <div class="container request-search-page">

        
        
        <div class="row">
            
            {{--<div class="col-lg-2"></div>--}}

            <div class="col-xl-12 col-lg-12 right-request">
                <h2 class="mb-5">Overview of your requests</h2>

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
                                <!--
                                <div class="turbo-gallery">
                                    <div>
                                        <img src="/images/search_galery/turbo/turbo.png">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/turbo/turbo.png">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/turbo/turbo.png">
                                    </div>
                                </div>
                                -->
                                
                                
                                <div class="turbo-gallery-for">
                                    <div>
                                        <img src="/images/search_galery/turbo/turbo.png">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/light/light.png">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/medium/medium.png">
                                    </div>
                                </div>
                                
                                
                                
                                
                                <div class="turbo-gallery-nav">
                                    <div>
                                        <img src="/images/search_galery/turbo/turbo.png">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/light/light.png">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/medium/medium.png">
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="card-inner-body pl-4">
                                <div class="type-price">
                                    <div>Turbo</div>
                                    <div><span>Price:</span> &#36;{{ number_format($searchResults->price_turbo, 2, '.', ' ') }}</div>
                                </div>
                                <ul class="card-body-details">
                                    <li>
                                        <span>Departure City:</span>
                                        <span>{{ $searchResults->departure }}</span>
                                    </li>
                                    <li>
                                        <span>Arrival City:</span>
                                        <span>{{ $searchResults->arrival }}</span>
                                    </li>
                                    <li>
                                        <span>Flight Time:</span>
                                        <span>{{ $searchResults->time_turbo }}</span>
                                    </li>
                                    <li>
                                        <span>Flight Date:</span>
                                        <span>{{ $params['flightDate'] }}</span>
                                    </li>
                                    <li>
                                        <span>Max Passengers:</span>
                                        <span>{{ $params['passengers'] }}</span>
                                    </li>
                                </ul>

                                <div class="book">
                                    <a href="{{ route('client.orders.confirm', [$params['searchId'], 'turbo'] ) }}" class="learn-more">Book now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($searchResults->price_light > 0)    
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-inner-image">
                                <div class="light-gallery">
                                    <div>
                                        <img src="/images/search_galery/light/light.png">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/light/light.png">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/light/light.png">
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner-body pl-4">
                                <div class="type-price">
                                    <div>Light</div>
                                    <div><span>Price:</span> &#36;{{ number_format($searchResults->price_light, 2, '.', ' ') }}</div>
                                </div>
                                <ul class="card-body-details">
                                    <li>
                                        <span>Departure City:</span>
                                        <span>{{ $searchResults->departure }}</span>
                                    </li>
                                    <li>
                                        <span>Arrival City:</span>
                                        <span>{{ $searchResults->arrival }}</span>
                                    </li>
                                    <li>
                                        <span>Flight Time:</span>
                                        <span>{{ $searchResults->time_light }}</span>
                                    </li>
                                    <li>
                                        <span>Flight Date:</span>
                                        <span>{{ $params['flightDate'] }}</span>
                                    </li>
                                    <li>
                                        <span>Max Passengers:</span>
                                        <span>{{ $params['passengers'] }}</span>
                                    </li>
                                </ul>
                                <div class="book">
                                    <a href="{{ route('client.orders.confirm', [$params['searchId'], 'light'] ) }}" class="learn-more">Book now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($searchResults->price_medium > 0)    
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-inner-image">
                                <div class="medium-gallery">
                                    <div>
                                        <img src="/images/search_galery/medium/medium.png">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/medium/medium.png">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/medium/medium.png">
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner-body pl-4">
                                <div class="type-price">
                                    <div>Medium</div>
                                    <div><span>Price:</span> &#36;{{ number_format($searchResults->price_medium, 2, '.', ' ') }}</div>
                                </div>
                                <ul class="card-body-details">
                                    <li>
                                        <span>Departure City:</span>
                                        <span>{{ $searchResults->departure }}</span>
                                    </li>
                                    <li>
                                        <span>Arrival City:</span>
                                        <span>{{ $searchResults->arrival }}</span>
                                    </li>
                                    <li>
                                        <span>Flight Time:</span>
                                        <span>{{ $searchResults->time_medium }}</span>
                                    </li>
                                    <li>
                                        <span>Flight Date:</span>
                                        <span>{{ $params['flightDate'] }}</span>
                                    </li>
                                    <li>
                                        <span>Max Passengers:</span>
                                        <span>{{ $params['passengers'] }}</span>
                                    </li>
                                </ul>
                                <div class="book">
                                    <a href="{{ route('client.orders.confirm', [$params['searchId'], 'medium'] ) }}" class="learn-more">Book now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($searchResults->price_heavy > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-inner-image">
                                <div class="heavy-gallery">
                                    <div>
                                        <img src="/images/search_galery/heavy/heavy.png">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/heavy/heavy.png">
                                    </div>
                                    <div>
                                        <img src="/images/search_galery/heavy/heavy.png">
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner-body pl-4">
                                <div class="type-price">
                                    <div>Heavy</div>
                                    <div><span>Price:</span> &#36;{{ number_format($searchResults->price_heavy, 2, '.', ' ') }}</div>
                                </div>
                                <ul class="card-body-details">
                                    <li>
                                        <span>Departure City:</span>
                                        <span>{{ $searchResults->departure }}</span>
                                    </li>
                                    <li>
                                        <span>Arrival City:</span>
                                        <span>{{ $searchResults->arrival }}</span>
                                    </li>
                                    <li>
                                        <span>Flight Time:</span>
                                        <span>{{ $searchResults->time_heavy }}</span>
                                    </li>
                                    <li>
                                        <span>Flight Date:</span>
                                        <span>{{ $params['flightDate'] }}</span>
                                    </li>
                                    <li>
                                        <span>Max Passengers:</span>
                                        <span>{{ $params['passengers'] }}</span>
                                    </li>
                                </ul>
                                <div class="book">
                                    <a href="{{ route('client.orders.confirm', [$params['searchId'], 'heavy'] ) }}" class="learn-more">Book now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                        
                @else
                
                    <p>We do not have such a flight, make a request e quote</p>

                @endif   
                
                <div class="pb-5"></div>
                    
                <div class="card mb-4 mt-5">
                    <div class="card-body">
                        <div class="card-inner-image">
                            <div class="request_quote-gallery">
                                <div>
                                    <img src="/images/search_galery/request_quote/04_rr_dm_wi-jet-in-the-sky.webp">
                                </div>
                                <div>
                                    <img src="/images/search_galery/request_quote/Baron_2_social.webp">
                                </div>
                                <div>
                                    <img src="/images/search_galery/request_quote/bombardier20challenger2030020ex_tcm36-3782.webp">
                                </div>
                                <div>
                                    <img src="/images/search_galery/request_quote/challenger-605-opt.webp">
                                </div>
                            </div>
                        </div>
                        <div class="card-inner-body pl-4">
                            <div class="type-price">
                                <div>SELECT SPECIFIC PLANE MODEL</div>
                            </div>
                            <form action="{{ route('client.search.requestQuote') }}" method="POST" id="request_quote">
                                @csrf
                                <div class="row d-flex justify-content-between request-quote-from-to mt-4 mb-4">
                                    <div class="ml-4">{{ $params['startPointName'] . ' - ' . $params['endPointnName'] }}</div>
                                    <div class="mr-4">{{ $params['flightDate'] }}</div>
                                </div>
                                <div class="form-group">
                                    <select name="flight_model" class="form-control" id="flight_model">
                                        <option value="">--- Nothing selected ---</option>
                                        <option value="nurbo">Turbo</option>
                                        <option value="light">Light</option>
                                        <option value="medium">Medium</option>
                                        <option value="heavy">Heavy</option>
                                    </select>
                                </div>
                                <div class="form-group mt-4">
                                    <label for="comment">Comment</label>
                                    <textarea type="text" name="comment" class="form-control" id="comment"></textarea>
                                </div>
                                <input type="hidden" name="result_id" value="{{ $params['searchId'] }}" id="result_id">
                                <input type="hidden" name="user_id" value="{{ $params['userId'] }}" id="user_id">
                                <input type="hidden" name="start_airport_name" value="{{ $params['startPointName'] }}" id="start_airport_name">
                                <input type="hidden" name="end_airport_name" value="{{ $params['endPointnName'] }}" id="end_airport_name">
                                <input type="hidden" name="departure_at" value="{{ $params['flightDate'] }}" id="departure_at">
                                <input type="hidden" name="pax" value="{{ $params['passengers'] }}" id="pax">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary mt-5">Request a Quote</button>
                                </div>
                            </form>
                        
                        </div>
                            
                    </div>
                </div>
                
                

            </div>
        </div>
    </div>

    <div class="container">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12">
                <!--div class="well well-sm"-->
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
                            
                        <!--div class="col-xs-2 col-md-3 text-center age">
                            <img src="https://placeholdit.imgix.net/~text?txtsize=40&txt=John%20Doe&w=200&h=200" class="img-circle img-responsive" alt="" />
    					</div-->
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
                <!--/div-->
            </div>
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

        /*
        $('.turbo-gallery').slick({
            dots: true,
            infinite: true,
            speed: 500,
            fade: true,
            slidesToShow: 1,
            adaptiveHeight: true,
            arrows: false,
        });
        
       
        */
       
        
        $('.turbo-gallery-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            dots: false,
            //asNavFor: '.turbo-gallery-nav',
        });
        
        
        
        $('.turbo-gallery-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.turbo-gallery-for',
            dots: false,
            centerMode: true,
            focusOnSelect: true,
            arrows: false,
        });
        
        

        
       
        
        $('.light-gallery').slick({
            dots: true,
            infinite: true,
            speed: 500,
            fade: true,
            slidesToShow: 1,
            adaptiveHeight: true,
            arrows: false,
        });
        
        $('.medium-gallery').slick({
            dots: true,
            infinite: true,
            speed: 500,
            fade: true,
            slidesToShow: 1,
            adaptiveHeight: true,
            arrows: false,
        });
        
        $('.heavy-gallery').slick({
            dots: true,
            infinite: true,
            speed: 500,
            fade: true,
            slidesToShow: 1,
            adaptiveHeight: true,
            arrows: false,
        });
        
        $('.request_quote-gallery').slick({
            dots: true,
            infinite: true,
            speed: 500,
            fade: true,
            slidesToShow: 1,
            adaptiveHeight: true,
            arrows: false,
        });


        $(function() {
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
                var _token = $('input[name="_token"]').val();
                
                if(start_airport_name.length > 0 && end_airport_name.length > 0 && flight_model.length > 0){
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
                            end_airport_name: end_airport_name
                        },
                        success:function(response){
                            console.log(response);
                        },
                    });
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
            
            
        });
    </script>

@endpush