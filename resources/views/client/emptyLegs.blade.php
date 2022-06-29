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
    <div class="section main-search-page main-search-emptyLeg">
        <div class="container">
            <div class="row">

                <div class="offset-md-1 col-md-12">
                    <form action="{{ route('client.flight.index') }}" method="GET" id="main-search-form">

                        @csrf
                        <div class="row form-body form-search-mobile mt-5">
                            <div class="col-lg-10 mb-2 mt-4 home-title">
                                <h1 class="text-uppercase">Search empty leg jet</h1>
                            </div>
                            <div class="mb-3 mt-2 ml-3 bd emptyLeg-filter">
                                <div class="input-group input-style">
                                    <input type="text"
                                           class="form-control from"
                                           placeholder="Departure Airport"
                                           aria-describedby="departure-airport"
                                           name="startPointName"
                                           id="startPointName"
                                           autocomplete="off"
                                           value=""
                                    >
                                    <input type="hidden" name="startPoint" autocomplete="off" value="">
                                    <input type="hidden" name="startAirport" autocomplete="off" value="">
                                    <div id="departureList"></div>
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="departure-airport">
                                        <img src="{{ asset('images/departure-icon.svg') }}" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-2 ml-3 bd emptyLeg-filter">
                                <div class="input-group input-style">
                                    <input type="text"
                                           class="form-control to"
                                           placeholder="Arrival Airport"
                                           aria-describedby="arrival-airport"
                                           name="endPointName"
                                           id="endPointName"
                                           autocomplete="off"
                                           value=""
                                    >
                                    <input type="hidden" name="endPoint" autocomplete="off" value="">
                                    <input type="hidden" name="endAirport" autocomplete="off" value="">
                                    <div id="arrivalList"></div>
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="arrival-airport">
                                        <img src="{{ asset('images/arrival-icon.svg') }}" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-2 pl-0 ml-3 pass-field">
                                <div class="input-group input-style">
                                    <input type="number" min="1" class="form-control bd-input" placeholder="Passengers" aria-describedby="passengers" name="passengers" autocomplete="off" value="">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bd-input" id="passengers" name="passengers" >
                                        <img src="{{ asset('images/passengers-icon.svg') }}" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-2 ml-3 bd emptyLeg-filter">
                                <div class="input-group input-style">
                                    <input type="text" class="form-control " name="flightDate" id="flightDate" placeholder="Date & Time" autocomplete="off" value="">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="date-time">
                                        <img src="{{ asset('images/date-icon.svg') }}" loading="lazy" class="icon-img" alt="..."></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="section map-section"></div>

    <div class="container request-search-page">

        <div class="row">
            <div class="col-xl-12 col-lg-12 right-request">
                <div id="search">
                    @forelse ($emptyLegs as $emptyLeg)
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

                                        <div class="card-inner-body pl-4">

                                            <div class="type-info-legs">
                                                <div class="type-price text-uppercase">
                                                    <span class="flight-type">{{__("$Type")}}</span>
                                                    <span style="font-size: 0.8rem;"><a href="/aircraft" title="{{__('ABOUT CLASS')}}">{{__('ABOUT CLASS')}}</a></span>
                                                </div>
                                                <div class="type-price">
                                                    <span class="flight-price">{{ $emptyLeg->date_departure->format('d/m/Y') }}</span>
                                                    <span class="flight-price-desc"></span>
                                                </div>
                                                <div class="type-price-legs">
                                                    <span class="flight-price">{!! ((int)$emptyLeg->price !== 0) ? htmlspecialchars_decode('&#36; ', ENT_HTML5) . number_format($emptyLeg->price, 2, '.', ' ') : 'Price on request.' !!}</span>
                                                    <span class="flight-price-desc">{{ ((int)$emptyLeg->price !== 0) ? __('Lowest Price (Incl. taxes)') : ''}}</span>
                                                </div>

                                                <div>
                                                    <span class="flight-price-desc">{{ __('From Airport')}}</span>
                                                    <span class="flight-price">{{ $emptyLeg->departureCity->name }}</span>
                                                </div>
                                                <div>
                                                    <span class="flight-price-desc">{{ __('To Airport')}}</span>
                                                    <span class="flight-price">{{ $emptyLeg->arrivalCity->name }}</span>
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
                                                "<div>
                                                    <button type='submit' class='price-empty-leg-submit'>" . __('Book now') . "</button>
                                                </div>"
                                                :
                                                "<div>
                                                    <button type='submit' class='request-empty-leg-submit'>" . __('Request a Quote') . "</button>
                                                </div>"
                                                !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    @empty
                        <div></div>
                    @endforelse

                    <div class="d-flex justify-content-center">
                        {!! $emptyLegs->links() !!}
                    </div>

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
    <script>
        $(document).ready(function(){

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
            /*
            $('.modal-content').observe(function () {
                $(this).find('span').tooltip();
            });
            */
            //$('.flight-type').css("background-color", "red");

            var nowDate = new Date();
            var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

            $('input[name="flightDate"]').daterangepicker({
                opens: 'left',
                keepEmptyValues: true,
                singleDatePicker: true,
                isInvalidDate: (e) => new Date(e) < today
            });

            $('input[name="flightDate"]').val('');
            $('input[name="flightDate"]').attr("placeholder","Date & Time");


            $('#startPointName, #endPointName, #flightDate').on("keyup change", function () {
 /*               alert($('input[name="flightDate"]').val());


            $(document).ready(function() {
                $(window).on('hashchange', function() {
                    if (window.location.hash) {
                        var page = window.location.hash.replace('?', '');
                        if (page == Number.NaN || page <= 0) {
                            return false;
                        } else {
                            getEmptyLegs(page);
                        }
                    }
                });
                alert(page);

                $(document).on('click', '.pagination .pagination-ajax a', function (e) {
                    getEmptyLegs($(this).attr('href').split('page=')[1]);
                    e.preventDefault();
                });
            });
            */
            /*
            function getPosts(page) {
                $.ajax({
                    url : '?page=' + page,
                    dataType: 'json',
                }).done(function (data) {
                    $('.posts').html(data);
                    location.hash = page;
                }).fail(function () {
                    alert('Posts could not be loaded.');
                });
            }
*/
 //           function getEmptyLegs(page) {
                    var startPointName = $('#startPointName').val();
                    var endPointName = $('#endPointName').val();
                    var flightDate = $('#flightDate').val();
                    var page = 1;
                    //flightDate.datepicker('setDate', $(this).val());
                    //alert(startPointName);
                    if (startPointName.length >= 3 || endPointName.length >= 3 || flightDate.length > 0) {
                        //alert(flightDate);

                        let _token = $('input[name="_token"]').val();
                        let output = '';
                        $.ajax({
                            url: '{{ route('client.empty-leg.ajax-search') }}',//+'?page=' + page,
                            method: 'GET',
                            type: 'json',
                            data: {
                                startPointName: startPointName,
                                endPointName: endPointName,
                                flightDate: flightDate,
                                _token: _token
                            }
//                            success: function (data) {
//console.log(data);





                            }).done(function (data) {
                            let page = "{{ !empty($filterEmptyLegs) ? $filterEmptyLegs->current_page : 1 }}";
                            //let page = 1;
                            alert (page);
                            console.log({!! !empty($filterEmptyLegs) ? $filterEmptyLegs->current_page : 1  !!});

                            {{-- var_dump(!empty($filterEmptyLegs) ? $filterEmptyLegs : 1 ) --}}

                            //$('.articles').html(data);
                            alert(data.filterEmptyLegs);
                            alert(data.filterEmptyLegs);
                            alert('TEST');
                            console.log(data.filterEmptyLegs);
                            {{--}}!! dd($filterEmptyLegs) !!--}}
                            if (data.filterEmptyLegs.length !== 0) {
                                $.each(data.filterEmptyLegs.data, function (idx, obj) {
                                    //console.log(idx)
                                    //alert(idx);
                                    //alert(obj);
                                    //$.each(obj, function(key, val) {
                                    //console.log(val);
//alert(obj.id);
//alert(obj.type_plane);
                                    //var objAirport = obj.airport;

                                    let type = (obj.type_plane).split("_").pop();
                                    let TYPE = type.toUpperCase();
                                    let Type = type.toLowerCase().replace(/(?<= )[^\s]|^./g, a => a.toUpperCase());

                                    let result_id = obj.id;
                                    let aircraft = Type;
                                    let startPointName = obj.departure_city.name;
                                    let endPointName = obj.arrival_city.name
                                    let startPoint = obj.departure_city.geonameid;
                                    let endPoint = obj.arrival_city.geonameid;
                                    let startAirport = obj.airport_departure.icao;
                                    let endAirport = obj.airport_departure.icao;
                                    //let departure_at = obj.date_departure;
                                    //var sqlDate = new Date(obj.date_departure);
                                    let departure_at = moment(new Date(obj.date_departure)).format('L');
//alert(obj.date_departure);
//alert(departure_at);
                                    //let departure_at = moment(obj.date_departure, "DD/MM/YYYY");
                                    let price = obj.price;

                                    //alert(Number(price).toFixed(0));
                                    //output += '<div id="search">

                                    (Number(price).toFixed(0) != 0) ?
                                        output += "<form action='{{ route('client.orders.confirm') }}' method='GET'>"
                                        :
                                        output += "<form action='{{ route('client.search.requestQuote') }}' method='GET'>";

                                    output += `<div class='card mb-4'>
                                            <div class='card-body'>

                                            <div class='card-inner-body pl-4'>

                                            <div class='type-info-legs'>
                                            <div class='type-price text-uppercase'>
                                                <span class='flight-type'>` + TYPE + `</span>
                                                <span style='font-size: 0.8rem;'><a href='/aircraft' title='{{__('ABOUT CLASS')}}'>{{__('ABOUT CLASS')}}</a></span>
                                            </div>
                                            <div class='type-price'>
                                                <span class='flight-price'>` + departure_at + `</span>
                                                <span class='flight-price-desc'></span>
                                            </div>
                                            <div class='type-price-legs'>
                                                <span class='flight-price'>`;
                                    (Number(price).toFixed(0) != 0) ?
                                        output += `{!! htmlspecialchars_decode('&#36; ', ENT_HTML5) !!}` + price
                                        :
                                        output += 'Price on request';
                                    output += `</span>
                                                <span class='flight-price-desc'>`;
                                    (Number(price).toFixed(0) != 0) ?
                                        output += "{{__('Lowest Price (Incl. taxes)')}}"
                                        :
                                        output += '';
                                    output += `</span>
                                            </div>

                                            <div>
                                                <span class='flight-price-desc'>{{ __('From Airport')}}</span>
                                                <span class='flight-price'>` + startPointName + `</span>
                                            </div>
                                            <div>
                                                <span class='flight-price-desc'>{{ __('To Airport')}}</span>
                                                <span class='flight-price'>` + endPointName + `</span>
                                            </div>

                                        <input type='hidden' name='result_id' value='` + result_id + `'>
                                        <input type='hidden' name='aircraft' value='` + aircraft + `'>
                                        <input type='hidden' name='startPointName' value='` + startPointName + `'>
                                        <input type='hidden' name='endPointName' value='` + endPointName + `'>
                                        <input type='hidden' name='startPoint' value='` + startPoint + `'>
                                        <input type='hidden' name='endPoint' value='` + endPoint + `'>
                                        <input type='hidden' name='startAirport' value='` + startAirport + `'>
                                        <input type='hidden' name='endAirport' value='` + endAirport + `'>
                                        <input type='hidden' name='departure_at' value='` + departure_at + `'>
                                        <input type='hidden' name='price' value='` + price + `'>
                                        <input type='hidden' name='type' value='emptyLeg'>
                                        <input type='hidden' name='page_name' value='reqest-emptyLeg-page'>`;

                                    (Number(price).toFixed(0) != 0) ?
                                        output += "<div><button type='submit' class='price-empty-leg-submit'>{{ __('Book now') }}</button></div>"
                                        :
                                        output += "<div><button type='submit' class='request-empty-leg-submit'>{{ __('Request a Quote') }}</button></div>";

                                    output += `</div>
                                                </div>
                                            </div>
                                        </div>`;
                                    output += "</form>";
                                });


                                //});
                                //});
                                output += '<div class="d-flex justify-content-center">{{ $filterEmptyLegs->links() ?? '' }}</div>';
                                {{-- dd() --}}
                                //location.hash = page;
                                {{--}}!! $emptyLegs->links() !!--}}
                                //</div>';
                            } else {
                                output += '<div class="text-center">No matches found</div>';
                            }

                            //output += 'test';
                            //alert(output);
                            $('#search').fadeIn();
                            $('#search').html(output);
                            }).fail(function () {
                            {{--}}!! var_dump($filterEmptyLegs->links ?? '') !!--}}
                                alert('Articles could not be loaded.');
                            });
                    }

                //}
            });
        });
    </script>
@endpush
