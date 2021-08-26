@extends('client.layouts.app')
@section('meta')
    <title>Requests | JetOnset</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
@endsection

@section('book_page', 'book-page-nav')

@section('content')
<div class="container header-page-image header-page-image-bg"></div>
    <div class="section main-search-page header-page-image-request-quote">
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

                    
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid request-search-page request-quote-page">
        
        <div class="row">
            <div class="col-xl-12 col-lg-12 mb-3 container-request-top-quote">
                
                <a href="{{ $pervis_search_url }}" class="btn btn-light back_arrow">Back to JET TYPE</a>
                
            </div>
        </div>

        <div class="row">

            <div class="col-xl-12 col-lg-12 right-request container-request-quote">


                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-inner-body pl-4">
                            <div class="custom-flight-page">
                                <div>Custom jet search:</div>
                                <p>route & AIRCRAFT</p>
                            </div>
                            <form action="{{ route('client.search.requestQuote') }}" method="GET" id="request_quote">

                                <div class="row">

                                    <div class="mb-3 mt-2 ml-3 start-point">
                                        <div class="input-group input-style-3">
                                            <label for="departure-airportRQ">From Airport</label>
                                            <input type="text"
                                                class="form-control from"
                                                placeholder="Departure Airport"
                                                aria-describedby="departure-airport"
                                                name="startPoint"
                                                autocomplete="off"
                                                value="{{ $params['start_airport_name'] }}"
                                                id="departure-airportRQ"
                                            >
                                            <div id="departureList"></div>

                                            <div class="w-100 position-relative stop-airpor-row {{ ( $params['from_stop_airport_name'] or $params['to_stop_airport_name'] or $params['stop_at'] ) ? '' : 'display-none' }}">
                                                <label for="from-stop-airportRQ" class="mt-3">From Stop Airport</label>
                                                <input type="text"
                                                    class="form-control from-stop w-100"
                                                    placeholder="From Stop Airport"
                                                    aria-describedby="from-stop-airport"
                                                    name="fromStopPoint"
                                                    autocomplete="off"
                                                    value="{{ $params['from_stop_airport_name'] ? $params['from_stop_airport_name'] : $params['end_airport_name'] }}"
                                                    id="from-stop-airportRQ" {{ $params['from_stop_airport_name'] ? '' : 'disabled' }}
                                                >
                                                <div id="fromStopList"></div>
                                            </div>
                                            
                                            <div class="w-100 position-relative return-airpor-row {{ ( $params['from_return_airport_name'] or $params['to_return_airport_name'] or $params['return_at'] ) ? '' : 'display-none' }}">
                                                <label for="from-return-airportRQ" class="mt-3">From Return Airport</label>
                                                <input type="text"
                                                    class="form-control from-return w-100"
                                                    placeholder="From Return Airport"
                                                    aria-describedby="from-return-airport"
                                                    name="fromReturnPoint"
                                                    autocomplete="off"
                                                    value="{{ $params['from_return_airport_name'] }}"
                                                    id="from-return-airportRQ" {{ $params['from_return_airport_name'] ? '' : 'disabled' }}
                                                >
                                                <div id="fromReturnList"></div>
                                            </div>

                                            <button type="button" class="mt-3" id="add-stop-button">{{ $params['from_stop_airport_name'] ? 'remove stop' : 'add stop' }}</button>
                                        </div>
                                    </div>
                                    <div class="mb-3 mt-2 pl-0 bd end-point">
                                        <div class="input-group input-style-2">
                                            <label for="arrival-airportRQ">To Airport</label>
                                            <input type="text"
                                                class="form-control to"
                                                placeholder="Arrival Airport"
                                                aria-describedby="arrival-airport"
                                                name="endPoint"
                                                autocomplete="off"
                                                value="{{ $params['end_airport_name'] }}"
                                                id="arrival-airportRQ"
                                            >
                                            <div id="arrivalList"></div>

                                            <div class="w-100 position-relative stop-airpor-row {{ ( $params['from_stop_airport_name'] or $params['to_stop_airport_name'] or $params['stop_at'] ) ? '' : 'display-none' }}">
                                                <label for="to-stop-airportRQ" class="mt-3">To Stop Airport</label>
                                                <input type="text"
                                                    class="form-control to-stop w-100"
                                                    placeholder="To Stop Airport"
                                                    aria-describedby="to-stop-point"
                                                    name="toStopPoint"
                                                    autocomplete="off"
                                                    value="{{ $params['to_stop_airport_name'] }}"
                                                    id="to-stop-airportRQ" {{ $params['to_stop_airport_name'] ? '' : 'disabled' }}
                                                >
                                                <div id="toStopList"></div>
                                            </div>
                                            
                                            <div class="w-100 position-relative return-airpor-row {{ ( $params['from_return_airport_name'] or $params['to_return_airport_name'] or $params['return_at'] ) ? '' : 'display-none' }}">
                                                <label for="to-return-airportRQ" class="mt-3">To Return Airport</label>
                                                <input type="text"
                                                    class="form-control to-return w-100"
                                                    placeholder="To Return Airport"
                                                    aria-describedby="to-return-airport"
                                                    name="toReturnPoint"
                                                    autocomplete="off"
                                                    value="{{ $params['to_return_airport_name'] ? $params['to_return_airport_name'] : $params['start_airport_name'] }}"
                                                    id="to-return-airportRQ" {{ $params['to_return_airport_name'] ? '' : 'disabled' }}
                                                >
                                                <div id="toReturnList"></div>
                                            </div>

                                            <div class="d-flex justify-content-center w-100">
                                                <button type="button" class="mt-3" id="add-stop-button-bottom">{{ $params['from_stop_airport_name'] ? 'remove stop' : 'add stop' }}</button>
                                                <button type="button" class="mt-3" id="add-return-button">{{ $params['to_return_airport_name'] ? 'remove return' : 'add return' }}</button>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="mb-3 mt-2 ml-3 dt-field">
                                        <div class="input-group input-style">
                                            <label for="flightDateRQ">Arrival Date</label>
                                            <input type="text" class="form-control " name="flightDate" placeholder="Date&Time" autocomplete="off" value="{{ $params['departure_at'] }}" id="flightDateRQ">

                                            <div class="stop-airpor-row {{ ( $params['from_stop_airport_name'] or $params['to_stop_airport_name'] or $params['stop_at'] ) ? '' : 'display-none' }}">
                                                <label for="stopFlightDateRQ" class="mt-3">Stop Date</label>
                                                <input type="text" class="form-control" name="stopFlightDate" placeholder="Date&Time" autocomplete="off" value="{{ $params['stop_at'] }}" {{ $params['stop_at'] ? '' : 'disabled' }} id="stopFlightDateRQ">
                                            </div>
                                            
                                            <div class="return-airpor-row {{ ( $params['from_return_airport_name'] or $params['to_return_airport_name'] or $params['return_at'] ) ? '' : 'display-none' }}">
                                                <label for="returnFlightDateRQ" class="mt-3">Return Date</label>
                                                <input type="text" class="form-control" name="returnFlightDate" placeholder="Date&Time" autocomplete="off" value="{{ $params['return_at'] }}" {{ $params['return_at'] ? '' : 'disabled' }} id="returnFlightDateRQ">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 mt-2 pl-0 ml-3 pass-field pf-request">
                                        <div class="input-group input-style">
                                            <label for="aircraftRQ">Preffered Aircraft</label>
                                            <div class="d-flex">
                                                <input type="text" class="form-control" placeholder="ANY MODEL" aria-describedby="aircraft" name="aircraft" autocomplete="off" value="{{ $params['aircraft'] }}" id="aircraftRQ">
                                                <button type="button" class="preff-air {{ $params['aircraft_one'] ? 'preff-air-with-additional' : '' }}" id="additional-air-one-button">+</button>
                                            </div>
                                            <div id="aircraftList"></div>

                                            <div class="additional-air-one mt-3 {{ $params['aircraft_one'] ? '' : 'display-none' }}" id="additional-air-one-block">
                                                <div class="d-flex">
                                                    <input type="text" class="form-control" placeholder="ANY MODEL" aria-describedby="aircraft_one" name="aircraft_one" autocomplete="off" value="{{ $params['aircraft_one'] }}" {{ $params['aircraft_one'] ? '' : 'disabled' }} id="aircraftRQ-one">
                                                    <button type="button" class="preff-air-remove">-</button>
                                                </div>
                                                <div id="aircraftList-one"></div>
                                            </div>

                                            <div class="additional-air-two mt-3 {{ $params['aircraft_two'] ? '' : 'display-none' }}" id="additional-air-two-block">
                                                <div class="d-flex">
                                                    <input type="text" class="form-control" placeholder="ANY MODEL" aria-describedby="aircraft_two" name="aircraft_two" autocomplete="off" value="{{ $params['aircraft_two'] }}" {{ $params['aircraft_two'] ? '' : 'disabled' }} id="aircraftRQ-two">
                                                    <button type="button" class="preff-air-remove">-</button>
                                                </div>
                                                <div id="aircraftList-two"></div>
                                            </div>
                                            <button type="button" id="add-aircraft-button" class="mt-3">Add Aircraft</button>
                                        </div>
                                    </div>

                                    <input type="hidden" name="result_id" value="{{ $params['result_id'] }}">
                                    <input type="hidden" name="flight_model" value="{{ $params['flight_model'] }}">

                                </div>
                                
                                <div class="custom-flight-bottom form-row">
                                    <p class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">PASSENGERS & baGGAGE</p>
                                    <p class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">extra</p>
                                </div>
                                
                                <div class="row">
                                    
                                    <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        
                                        <div class="row">
                                            <div class="col-sm-3 pr-2">
                                                <label for="passengers">Passengers</label>
                                                <input type="number" min="1" class="form-control" aria-describedby="pax" name="pax" autocomplete="off" value="{{ $params['pax'] }}" id="passengers">
                                            </div>
                                            <div class="col-sm-3 pl-1 pr-3">
                                                <label for="pets">PETS</label>
                                                <input type="number" min="0" class="form-control" aria-describedby=pets" name="pets" autocomplete="off" value="{{ $params['pets'] }}" id="pets">
                                            </div>
                                            <div class="col-sm-3 pl-2 pr-2">
                                                <label for="bags">bagS</label>
                                                <input type="number" min="0" class="form-control" aria-describedby="bags" name="bags" autocomplete="off" value="{{ $params['bags'] }}" id="bags">
                                            </div>
                                            <div class="col-sm-3 pl-1">
                                                <label for="lbags">large baggage</label>
                                                <input type="number" min="0" class="form-control" aria-describedby="lbags" name="lbags" autocomplete="off" value="{{ $params['lbags'] }}" id="lbags">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                        <div class="row">
                                            <p class="extra-title">extra options</p>
                                        </div>
                                        
                                        <div class="row extra-block">
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" aria-describedby="wifi" name="wifi" autocomplete="off" value="yes" {{ ($params['wifi'] == 'yes' ? ' checked' : '') }} id="wifi"> 
                                                <label class="form-check-label" for="wifi">Wi-Fi</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" aria-describedby="lavatory" name="lavatory" autocomplete="off" value="yes" {{ ($params['lavatory'] == 'yes' ? ' checked' : '') }} id="lavatory">  
                                                <label class="form-check-label" for="lavatory">Lavatory</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" aria-describedby="disabilities" name="disabilities" autocomplete="off" value="yes" {{ ($params['disabilities'] == 'yes' ? ' checked' : '') }} id="disabilities">
                                                <label class="form-check-label" for="disabilities">People with disabilities</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" aria-describedby="catering" name="catering" autocomplete="off" value="yes" {{ ($params['catering'] == 'yes' ? ' checked' : '') }} id="catering">
                                                <label class="form-check-label" for="catering">Catering</label>
                                            </div>
                                            
                                            <input type="hidden" name="page_name" value="reqest-page">
                                        
                                        </div>
                                    </div>
 
                                </div>


                                <div class="request-quote-block">
                                    <input type="text" name="comment" class="form-control" placeholder="Write your preferences" value="{{ $params['comment'] }}">
                                    <div>
                                        <p>Average reply: <span>3-6 hours</span></p>
                                        <button type="submit" class="request-quote-submit-page pull-right">SEND REQUEST</button>
                                    </div>
                                </div>
                            </form>

                            
                        </div>

                    </div>
                </div>

                <div class="pb-5"></div>

            </div>
        </div>
    </div>

@endsection


@push('scripts')
    
    <script type="text/javascript">
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        var maxLimitDate = new Date(nowDate.getFullYear() + 1, nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        var minDateForSecondPicker;
        $(function() {

            $('input[name="flightDate"], input[name="stopFlightDate"], input[name="returnFlightDate"]').daterangepicker({
                opens: 'left',
                keepEmptyValues: true,
                singleDatePicker: true,
                minDate: today,
            });
            //$('input[name="flightDate"], input[name="stopFlightDate"], input[name="returnFlightDate"]').val('');

            @if($params['departure_at'] === "")
                $('input[name="flightDate"]').val('');
            @endif
            
            @if($params['stop_at'] === "")
                $('input[name="stopFlightDate"]').val('');
            @endif
            
            @if($params['return_at'] === "")
                $('input[name="returnFlightDate"]').val('');
            @endif

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

                            $.each(withoutDuplicates, function(idx, obj) {
                                if (obj.name !== null && obj.iata !== null && (obj.name.toLowerCase().includes(query.toLowerCase()) || obj.iata.toLowerCase().includes(query.toLowerCase()))) {
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
                                if (obj.name !== null && obj.iata !== null && (obj.name.toLowerCase().includes(query.toLowerCase()) || obj.iata.toLowerCase().includes(query.toLowerCase()))) {
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


            $('input.from-stop').keyup(function(){
                var query = $(this).val();
                //alert(query);
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
                                if (obj.name !== null && obj.iata !== null && (obj.name.toLowerCase().includes(query.toLowerCase()) || obj.iata.toLowerCase().includes(query.toLowerCase()))) {
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
                            $('#fromStopList').fadeIn();
                            $('#fromStopList').html(output);
                        }
                    });
                }
            });

            $(document).on('click', '#fromStopList li', function(e){
                e.preventDefault();
                $('input.from-stop').val($(this).text());
                $('#fromStopList').fadeOut();
            });

            
            $('input.to-stop').keyup(function(){
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
                                if (obj.name !== null && obj.iata !== null && (obj.name.toLowerCase().includes(query.toLowerCase()) || obj.iata.toLowerCase().includes(query.toLowerCase()))) {
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
                            $('#toStopList').fadeIn();
                            $('#toStopList').html(output);
                        }
                    });
                }
            });

            $(document).on('click', '#toStopList li', function(e){
                e.preventDefault();
                $('input.to-stop').val($(this).text());
                $('#toStopList').fadeOut();
            });


            $('input.from-return').keyup(function(){
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
                                if (obj.name !== null && obj.iata !== null &&  (obj.name.toLowerCase().includes(query.toLowerCase()) || obj.iata.toLowerCase().includes(query.toLowerCase()))) {
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
                            $('#fromReturnList').fadeIn();
                            $('#fromReturnList').html(output);
                        }
                    });
                }
            });

            $(document).on('click', '#fromReturnList li', function(e){
                e.preventDefault();
                $('input.from-return').val($(this).text());
                $('#fromReturnList').fadeOut();
            });
            

            $('input.to-return').keyup(function(){
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
                                if (obj.name !== null && obj.iata !== null && (obj.name.toLowerCase().includes(query.toLowerCase()) || obj.iata.toLowerCase().includes(query.toLowerCase()))) {
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
                            $('#toReturnList').fadeIn();
                            $('#toReturnList').html(output);
                        }
                    });
                }
            });

            $(document).on('click', '#toReturnList li', function(e){
                e.preventDefault();
                $('input.to-return').val($(this).text());
                $('#toReturnList').fadeOut();
            });
            

            $('input#aircraftRQ').keyup(function(){
                var query = $(this).val();
                if(query != '' && query.length >= 3){
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "/api/types",
                        method: "GET",
                        data: {query:query, _token:_token},
                        success: function(data){
                            var lookup = {};
                            var output = '<ul class="dropdown-menu">';
                            $.each(data, function(idx, obj) {
                                if (obj.type !== null && obj.type.toLowerCase().includes(query.toLowerCase())) {
                                    output += '<li><a href="' + obj.id + '">' + obj.type + '</a></li>';
                                }
                            });
                            output += '</ul>';
                            $('#aircraftList').fadeIn();
                            $('#aircraftList').html(output);
                        }
                    });
                }
            });

            $(document).on('click', '#aircraftList li', function(e){
                e.preventDefault();
                $('input#aircraftRQ').val($(this).text());
                $('#aircraftList').fadeOut();
            });
            
            
            $('input#aircraftRQ-one').keyup(function(){
                var query = $(this).val();
                if(query != '' && query.length >= 3){
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "/api/types",
                        method: "GET",
                        data: {query:query, _token:_token},
                        success: function(data){
                            var lookup = {};
                            var output = '<ul class="dropdown-menu">';
                            $.each(data, function(idx, obj) {
                                if (obj.type !== null && obj.type.toLowerCase().includes(query.toLowerCase())) {
                                    output += '<li><a href="' + obj.id + '">' + obj.type + '</a></li>';
                                }
                            });
                            output += '</ul>';
                            $('#aircraftList-one').fadeIn();
                            $('#aircraftList-one').html(output);
                        }
                    });
                }
            });

            $(document).on('click', '#aircraftList-one li', function(e){
                e.preventDefault();
                $('input#aircraftRQ-one').val($(this).text());
                $('#aircraftList-one').fadeOut();
            });

            
            $('input#aircraftRQ-two').keyup(function(){
                var query = $(this).val();
                if(query != '' && query.length >= 3){
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "/api/types",
                        method: "GET",
                        data: {query:query, _token:_token},
                        success: function(data){
                            var lookup = {};
                            var output = '<ul class="dropdown-menu">';
                            $.each(data, function(idx, obj) {
                                if (obj.type !== null && obj.type.toLowerCase().includes(query.toLowerCase())) {
                                    output += '<li><a href="' + obj.id + '">' + obj.type + '</a></li>';
                                }
                            });
                            output += '</ul>';
                            $('#aircraftList-two').fadeIn();
                            $('#aircraftList-two').html(output);
                        }
                    });
                }
            });

            $(document).on('click', '#aircraftList-two li', function(e){
                e.preventDefault();
                $('input#aircraftRQ-two').val($(this).text());
                $('#aircraftList-two').fadeOut();
            });
            

            $('body').on('click', function(){
                $('#departureList').fadeOut();
                $('#arrivalList').fadeOut();
                $('#stopList').fadeOut();
                $('#returnList').fadeOut();
                $('#aircraftList').fadeOut();
                $('#fromStopList').fadeOut();
                $('#toStopList').fadeOut();
                $('#fromReturnList').fadeOut();
                $('#toReturnList').fadeOut();
                $('#aircraftList-one').fadeOut();
                $('#aircraftList-two').fadeOut();
            });


            $('.search-breadcrumb a').click(function(e){
                e.preventDefault();
                $('.form-body input[name="startPoint"]').val($(this).data("from"));
                $('.form-body input[name="endPoint"]').val($(this).data("to"));
            });
            
            if($(".stop-airpor-row").css("display") == "block"){
                $('#from-stop-airportRQ, #to-stop-airportRQ, #stopFlightDateRQ').prop('disabled', false);
            }else{
                $('#from-stop-airportRQ, #to-stop-airportRQ, #stopFlightDateRQ').prop('disabled', true);
            }
            
            $('#add-stop-button, #add-stop-button-bottom').click(function(e){
                e.preventDefault();
                $(this).text($(this).text() == "add stop"?"remove stop":"add stop");
                $('.stop-airpor-row').toggle();

                if($(".stop-airpor-row").css("display") == "block"){
                    $('#from-stop-airportRQ, #to-stop-airportRQ, #stopFlightDateRQ').prop('disabled', false);
                }else{
                    $('#from-stop-airportRQ, #to-stop-airportRQ, #stopFlightDateRQ').prop('disabled', true);
                }
                
                /*
                if($('#from-stop-airportRQ').prop('disabled') || $('#to-stop-airportRQ').prop('disabled') || $('#stopFlightDateRQ').prop('disabled')){
                    $('#from-stop-airportRQ, #to-stop-airportRQ, #stopFlightDateRQ').prop('disabled', false);
                }else{
                    $('#from-stop-airportRQ, #to-stop-airportRQ, #stopFlightDateRQ').prop('disabled', true);
                }
                */
            });
            
            
            if($(".return-airpor-row").css("display") == "block"){
                $('#from-return-airportRQ, #to-return-airportRQ, #returnFlightDateRQ').prop('disabled', false);
            }else{
                $('#from-return-airportRQ, #to-return-airportRQ, #returnFlightDateRQ').prop('disabled', true);
            }
            
            $('#add-return-button').click(function(e){
                e.preventDefault();
                $(this).text($(this).text() == "add return"?"remove return":"add return");
                $('.return-airpor-row').toggle();

                if($(".return-airpor-row").css("display") == "block"){
                    $('#from-return-airportRQ, #to-return-airportRQ, #returnFlightDateRQ').prop('disabled', false);
                }else{
                    $('#from-return-airportRQ, #to-return-airportRQ, #returnFlightDateRQ').prop('disabled', true);
                }
                
                /*
                if($('#from-return-airportRQ').prop('disabled') == true || $('#to-return-airportRQ').prop('disabled') == true || $('#returnFlightDateRQ').prop('disabled') == true){
                    alert('ok');
                    $('#from-return-airportRQ, #to-return-airportRQ, #returnFlightDateRQ').prop('disabled', false);
                }else{
                    alert('no');
                    $('#from-return-airportRQ, #to-return-airportRQ, #returnFlightDateRQ').prop('disabled', true);
                }
                */
            });

            
            $('.search-breadcrumb a').click(function(e){
                e.preventDefault();
                $('#request_quote input[name="startPoint"]').val($(this).data("from"));
                $('#request_quote input[name="endPoint"]').val($(this).data("to"));
            });


            $('#request_quote').submit(function(e){
                var start_point = $(this).find('input[name="startPoint"]').val();
                var end_point = $(this).find('input[name="endPoint"]').val();
                var flight_date = $(this).find('input[name="flightDate"]').val();
                var passengers = $(this).find('input[name="pax"]').val();
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
                        $(this).find('input[name="pax"]').parent('div').append(html_message);
                    }
                    e.preventDefault();
                }
            });


            $('#additional-air-one-button').click(function(e){
                e.preventDefault();
                $('#additional-air-one-block').show();
                $('#additional-air-one-block #aircraftRQ-one').prop('disabled', false);
                $(this).addClass('preff-air-with-additional');
                $('#add-aircraft-button').show();
            });


            if($('#additional-air-one-button').hasClass('preff-air-with-additional')){
                $('#add-aircraft-button').show();
            }


            $('#add-aircraft-button').click(function(e){
                e.preventDefault();
                
                if($('#additional-air-one-block').css('display') == 'none'){
                    $('#additional-air-one-block').show();
                    $('#additional-air-one-block #aircraftRQ-one').prop('disabled', false);
                }else if($('#additional-air-two-block').css('display') == 'none'){
                    $('#additional-air-two-block').show();
                    $('#additional-air-two-block #aircraftRQ-two').prop('disabled', false);
                }
                //$('#additional-air-two-block').show();
                //$('#additional-air-one-block').show();
            });


            $('.preff-air-remove').click(function(e){
                e.preventDefault();
                $(this).parent('div').parent('div').hide();
                $(this).prev('input').prop('disabled', true);
                //$('#additional-air-two-block').show();
            });

        });
    </script>

@endpush
