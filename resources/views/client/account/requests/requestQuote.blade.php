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
                
                <a href="{{ URL::previous() }}" class="btn btn-light back_arrow">Back to JET TYPE</a>
                
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

                                            <input type="text"
                                                class="form-control stop {{ $params['stop_airport_name'] ? '' : 'display-none' }}"
                                                placeholder="Stop Airport"
                                                aria-describedby="departure-airport"
                                                name="stopPoint"
                                                autocomplete="off"
                                                value="{{ $params['stop_airport_name'] }}"
                                                id="stop-airportRQ" {{ $params['stop_airport_name'] ? '' : 'disabled' }}
                                            >
                                            <div id="stopList"></div>

                                            <button type="button" id="add-stop-button">{{ $params['stop_airport_name'] ? 'remove stop' : 'add stop' }}</button>
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

                                            <input type="text"
                                                class="form-control return {{ $params['return_airport_name'] ? '' : 'display-none' }}"
                                                placeholder="Return Airport"
                                                aria-describedby="arrival-airport"
                                                name="returnPoint"
                                                autocomplete="off"
                                                value="{{ $params['return_airport_name'] }}"
                                                id="return-airportRQ" {{ $params['return_airport_name'] ? '' : 'disabled' }}
                                            >
                                            <div id="returnList"></div>

                                            <button type="button" id="add-return-button">{{ $params['return_airport_name'] ? 'remove return' : 'add return' }}</button>
                                        </div>
                                    </div>

                                    <div class="mb-3 mt-2 ml-3 dt-field">
                                        <div class="input-group input-style">
                                            <label for="flightDateRQ">arrival date</label>
                                            <input type="text" class="form-control " name="flightDate" placeholder="Date&Time" autocomplete="off" value="{{ $params['departure_at'] }}" id="flightDateRQ">
                                        </div>

                                    </div>
                                    <div class="mb-3 mt-2 pl-0 ml-3 pass-field">
                                        <div class="input-group input-style">
                                            <label for="aircraftRQ">preffered aircraft</label>
                                            <input type="text" class="form-control" placeholder="ANY MODEL" aria-describedby="aircraft" name="aircraft" autocomplete="off" value="{{ $params['aircraft'] }}" id="aircraftRQ">
                                            <div id="aircraftList"></div>
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
                                                <input type="number" min="1" class="form-control" aria-describedby=pets" name="pets" autocomplete="off" value="{{ $params['pets'] }}" id="pets">
                                            </div>
                                            <div class="col-sm-3 pl-2 pr-2">
                                                <label for="bags">bagS</label>
                                                <input type="number" min="1" class="form-control" aria-describedby="bags" name="bags" autocomplete="off" value="{{ $params['bags'] }}" id="bags">
                                            </div>
                                            <div class="col-sm-3 pl-1">
                                                <label for="lbags">large baggage</label>
                                                <input type="number" min="1" class="form-control" aria-describedby="lbags" name="lbags" autocomplete="off" value="{{ $params['lbags'] }}" id="lbags">
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

        $(function() {

            $('input[name="flightDate"]').daterangepicker({
                opens: 'left',
                keepEmptyValues: true,
                singleDatePicker: true,
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


            $('input.stop').keyup(function(){
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
                            $('#stopList').fadeIn();
                            $('#stopList').html(output);
                        }
                    });
                }
            });

            $(document).on('click', '#stopList li', function(e){
                e.preventDefault();
                $('input.stop').val($(this).text());
                $('#stopList').fadeOut();
            });

            
            $('input.return').keyup(function(){
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
                            $('#returnList').fadeIn();
                            $('#returnList').html(output);
                        }
                    });
                }
            });

            $(document).on('click', '#returnList li', function(e){
                e.preventDefault();
                $('input.return').val($(this).text());
                $('#returnList').fadeOut();
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
                                if (obj.type.toLowerCase().includes(query.toLowerCase())) {
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


            $('body').on('click', function(){
                $('#departureList').fadeOut();
                $('#arrivalList').fadeOut();
                $('#stopList').fadeOut();
                $('#returnList').fadeOut();
                $('#aircraftList').fadeOut();
            });


            $('.search-breadcrumb a').click(function(e){
                e.preventDefault();
                $('.form-body input[name="startPoint"]').val($(this).data("from"));
                $('.form-body input[name="endPoint"]').val($(this).data("to"));
            });
            
            $('#add-stop-button').click(function(e){
                e.preventDefault();
                $(this).text($(this).text() == "add stop"?"remove stop":"add stop");
                $('#stop-airportRQ').toggle();

                if($('#stop-airportRQ').prop('disabled')){
                    $('#stop-airportRQ').prop('disabled', false);
                }else{
                    $('#stop-airportRQ').prop('disabled', true);
                }

            });
            
            $('#add-return-button').click(function(e){
                e.preventDefault();
                $(this).text($(this).text() == "add return"?"remove return":"add return");
                $('#return-airportRQ').toggle();
                
                if($('#return-airportRQ').prop('disabled')){
                    $('#return-airportRQ').prop('disabled', false);
                }else{
                    $('#return-airportRQ').prop('disabled', true);
                }
                
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

        });
    </script>

@endpush