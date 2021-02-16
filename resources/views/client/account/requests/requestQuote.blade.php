@extends('client.layouts.app')
@section('meta')
    <title>Requests | JetOnset</title>
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
                            <div class="custom-flight">
                                <div>Custom jet search:</div>
                                <p>route & AIRCRAFT</p>
                            </div>
                            <form action="{{ route('client.search.requestQuote') }}" method="GET" id="request_quote">

                                <div class="row">
                                    
                                    <div class="mb-3 mt-2 ml-3 start-point">
                                        <div class="input-group input-style-3">
                                            <input type="text"
                                                class="form-control from"
                                                placeholder="Departure Airport"
                                                aria-describedby="departure-airport"
                                                name="startPoint"
                                                autocomplete="off"
                                                value="{{ $params['start_airport_name'] }}"
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
                                                value="{{ $params['end_airport_name'] }}"
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
                                            <input type="text" class="form-control " name="flightDate" placeholder="Date&Time" autocomplete="off" value="{{ $params['departure_at'] }}">
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
                                            <input type="number" min="1" class="form-control bd-input" placeholder="Passengers" aria-describedby="passengers" name="passengers" autocomplete="off" value="{{ $params['pax'] }}">
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="result_id" value="{{ $params['result_id'] }}">

                                </div>

                                <div class="form-row">
                                    <div class="col">
                                        <label for="flight_model">Preferred aircraft: {{ $params['flight_model'] }}</label>
                                        <select name="flight_model" class="form-control" id="flight_model">
                                            <option value="">--- Nothing selected ---</option>
                                            <option value="turbo" {{ $params['flight_model'] == "turbo"? 'selected':'' }}>Turbo</option>
                                            <option value="light" {{ $params['flight_model'] == "light"? 'selected':'' }}>Light</option>
                                            <option value="medium" {{ $params['flight_model'] == "medium"? 'selected':'' }}>Medium</option>
                                            <option value="heavy" {{ $params['flight_model'] == "heavy"? 'selected':'' }}>Heavy</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="comment">Comment</label>
                                        <textarea type="text" name="comment" class="form-control" id="comment">{{ $params['comment'] }}</textarea>
                                    </div>
                                </div>

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

            $('.search-breadcrumb a').click(function(e){
                e.preventDefault();
                $('.form-body input[name="startPoint"]').val($(this).data("from"));
                $('.form-body input[name="endPoint"]').val($(this).data("to"));
            });


        });
    </script>

@endpush