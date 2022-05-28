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
                            <div class="mb-3 mt-2 ml-3 bd emptyLeg-filter">
                                <div class="input-group input-style">
                                    <input type="text" class="form-control " name="flightDate" placeholder="Date&Time" autocomplete="off" value="">
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
                <form action="{{ route('client.search.requestQuote') }}" method="GET" id="request_empty_leg">
{{-- dd($emptyLegs) --}}
                    @forelse ($emptyLegs as $emptyLeg)
                        @php
                            $type = Str::after($emptyLeg->type_plane, '_');
                            $TYPE = Str::upper($type);
                            $Type = Str::ucfirst($type);
							#dd($emptyLeg);
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
                                                    <span class="flight-price">{{ $emptyLeg->departureCity->name}}</span>
                                                </div>
                                                <div>
                                                    <span class="flight-price-desc">{{ __('To Airport')}}</span>
                                                    <span class="flight-price">{{ $emptyLeg->arrivalCity->name }}</span>
                                                </div>
                                                {!! ((int)$emptyLeg->price !== 0) ?
                                                "<div>
                                                    <a href=". route('client.orders.confirm', [$emptyLeg->id, 'emptyLeg'] ) ." class='book btn book-now'>" . __('Book now') . "</a>
                                                </div>"
                                                :
                                                "<div class='text-right pull-right'>
                                                    <button type='submit' class='request-quote-submit pull-right'>Request a Quote</button>
                                                    <a href=". route('client.orders.confirm', [$emptyLeg->id, 'emptyLeg'] ) ." class='request-quote-submit pull-right'>" . __('Request a Quote') . "</a>
                                                </div>"
                                                !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    @empty
                        <div></div>
                    @endforelse
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
        });
    </script>
@endpush
