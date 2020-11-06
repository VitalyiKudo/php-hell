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

                {{--<p class="card-title"><span>0</span> results are available</p>--}}
            
            
                
            
            
                @if ($messages)
                    <div class="alert alert-danger">
                      <ul>
                          @foreach ($messages->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                    </div><br />
                @endif
            
                
                
                
            
                <div class="card mb-4">

                    
                    
                        
                        
                        <form action="{{ route('client.search.index') }}" method="GET">
                            @csrf
                            <div class="row card-body">
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
                                            <img src="/images/departure-icon.svg" class="icon-img" alt="..."></span>
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
                                            <img src="/images/arrival-icon.svg" class="icon-img" alt="..."></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 mt-2 ml-3" style="width: 19% !important">
                                    <div class="input-group input-style">
                                        <input type="text" class="form-control " name="flightDate" placeholder="Date&Time" value="{{ $params['flightDate'] }}">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" id="date-time">
                                            <img src="/images/date-icon.svg" class="icon-img" alt="..."></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="mb-3 mt-2 pl-0 ml-3" style="width:16% !important">
                                    <div class="input-group input-style">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text bd-input" id="passengers" name="passengers" >
                                            <img src="/images/passengers-icon.svg" class="icon-img" alt="..."></span>
                                        </div>
                                        <input type="number" min="0" class="form-control bd-input" placeholder="Passengers" aria-describedby="passengers" name="passengers" value="{{ $params['passengers'] }}">

                                    </div>
                                </div>

                                <div class="form-container-1 mt-2 ml-3" style="width:11% !important">
                                    <button type="submit" class="btn">Search Jet</button>
                                </div>
                            </div>
                        </form>
                        
                        
                    
                    
                    
                </div>
            

            
            
                
                @if($searchResults and ($searchResults->price_turbo > 0 or $searchResults->price_light > 0 or $searchResults->price_medium > 0 or $searchResults->price_heavy > 0)) 

                    @if($searchResults->price_turbo > 0)         
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-auto green-box"></div>
                                <div class="col-md-auto red-box"></div>
                                <div class="col-md-auto yellow-box"></div>

                                <div class="col-md-2 icao">
                                    <p>{{ $params['flightDate'] }}</p> 
                                </div>
                                <div class="col-md-3 country">{{ 'Turbo: '.$searchResults->departure. ' - '.$searchResults->arrival }}</div>
                                <div class="col-md-2 date">
                                    {{ $searchResults->time }}
                                </div>
                                <div class="col-md-2 price">
                                    {{ number_format($searchResults->price_turbo, 2, '.', ' ') }} &euro;
                                </div>
                                <div class="col-md-2 book">
                                    <a href="{{ route('client.orders.confirm', [$params['searchId'], 'turbo'] ) }}" class="btn">Book now</a>
                                </div>
                                <div class="col-md-auto arrow">▼</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($searchResults->price_light > 0)    
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-auto green-box"></div>
                                <div class="col-md-auto red-box"></div>
                                <div class="col-md-auto yellow-box"></div>

                                <div class="col-md-2 icao">
                                    <p>{{ $params['flightDate'] }}</p> 
                                </div>
                                <div class="col-md-3 country">{{ 'Light: '.$searchResults->departure. ' - '.$searchResults->arrival }}</div>
                                <div class="col-md-2 date">
                                    {{ $searchResults->time }}
                                </div>
                                <div class="col-md-2 price">
                                    {{ number_format($searchResults->price_light, 2, '.', ' ') }} &euro;
                                </div>
                                <div class="col-md-2 book">
                                    <a href="{{ route('client.orders.confirm', [$params['searchId'], 'light'] ) }}" class="btn">Book now</a>
                                </div>
                                <div class="col-md-auto arrow">▼</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($searchResults->price_medium > 0)    
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-auto green-box"></div>
                                <div class="col-md-auto red-box"></div>
                                <div class="col-md-auto yellow-box"></div>

                                <div class="col-md-2 icao">
                                    <p>{{ $params['flightDate'] }}</p> 
                                </div>
                                <div class="col-md-3 country">{{ 'Medium: '.$searchResults->departure. ' - '.$searchResults->arrival }}</div>
                                <div class="col-md-2 date">
                                    {{ $searchResults->time }}
                                </div>
                                <div class="col-md-2 price">
                                    {{ number_format($searchResults->price_medium, 2, '.', ' ') }} &euro;
                                </div>
                                <div class="col-md-2 book">
                                    <a href="{{ route('client.orders.confirm', [$params['searchId'], 'medium'] ) }}" class="btn">Book now</a>
                                </div>
                                <div class="col-md-auto arrow">▼</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($searchResults->price_heavy > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-auto green-box"></div>
                                <div class="col-md-auto red-box"></div>
                                <div class="col-md-auto yellow-box"></div>

                                <div class="col-md-2 icao">
                                    <p>{{ $params['flightDate'] }}</p> 
                                </div>
                                <div class="col-md-3 country">{{ 'Heavy: '.$searchResults->departure. ' - '.$searchResults->arrival }}</div>
                                <div class="col-md-2 date">
                                    {{ $searchResults->time }}
                                </div>
                                <div class="col-md-2 price">
                                    {{ number_format($searchResults->price_heavy, 2, '.', ' ') }} &euro;
                                </div>
                                <div class="col-md-2 book">
                                    <a href="{{ route('client.orders.confirm', [$params['searchId'], 'heavy'] ) }}" class="btn">Book now</a>
                                </div>
                                <div class="col-md-auto arrow">▼</div>
                            </div>
                        </div>
                    </div>
                    @endif

                        
                @else
                
                    <p>We do not have such a flight, make a request e quote</p>

                @endif   
                
                <hr>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('client.search.requestQuote') }}" method="POST" id="request_quote">
                            @csrf
                            <div class="row align-items-center">
                                <div class="col-md-auto green-box"></div>
                                <div class="col-md-auto red-box"></div>
                                <div class="col-md-auto yellow-box"></div>
                                    <div class="col-md-4 icao">
                                        <select name="flight_model" class="form-control" id="flight_model">
                                            <option>King Air 200</option>
                                            <option>TBM 850</option>
                                            <option>King Air 350</option>
                                            <option>Learjet 75</option>
                                            <option>TBM 850</option>
                                        </select>
                                    </div>
                                
                                    <div class="col-md-3 country">  {{ $params['startPointName'] . ' - ' . $params['endPointnName'] }}</div>

                                    <div class="col-md-2 price">
                                        {{ $params['flightDate'] }}
                                    </div>

                                    <button type="submit" class="btn btn-primary">Request a Quote</button>
                            </div>
                            
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea type="text" name="comment" class="form-control" id="comment"></textarea>
                            </div>
                            
                            <input type="hidden" name="result_id" value="{{ $params['searchId'] }}" id="result_id">
                            <input type="hidden" name="user_id" value="{{ $params['userId'] }}" id="user_id">
                            <input type="hidden" name="start_airport_name" value="{{ $params['startPointName'] }}" id="start_airport_name">
                            <input type="hidden" name="end_airport_name" value="{{ $params['endPointnName'] }}" id="end_airport_name">
                            <input type="hidden" name="departure_at" value="{{ $params['flightDate'] }}" id="departure_at">
                            <input type="hidden" name="pax" value="{{ $params['passengers'] }}" id="pax">
                        </form>
                            
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
@endsection


@push('scripts')
    <script type="text/javascript">

        $(function() {
            
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
                
                if(start_airport_name.length > 0 && end_airport_name.length > 0){
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