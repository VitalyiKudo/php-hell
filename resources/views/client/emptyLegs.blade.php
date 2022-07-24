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
                                    <input type="number" min="1" class="form-control bd-input" placeholder="Passengers" autocomplete="off" value="1" id="pax" name="pax">
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
                @if (count($emptyLegs) > 0)
                    <section class="emptyLegs">
                        @include('client.emptyLegs-load')
                    </section>
                @else
                    <div class="text-center not-found-message">We do not have such a flight, make a request a quote</div>
                @endif
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

            var nowDate = new Date();
            var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

            $('input[name="flightDate"]').daterangepicker({
                opens: 'left',
                keepEmptyValues: true,
                singleDatePicker: true,
                autoApply: true,
                autoUpdateInput: false,
                autoClose: true,
                locale: {
                    "cancelLabel": 'Clear',
                    "applyLabel": 'Apply',
                    format: 'MM/DD/YYYY'
                },
                isInvalidDate: (e) => new Date(e) < today
            }).on("apply.daterangepicker", function(e, picker) {
                picker.element.val(picker.startDate.format(picker.locale.format));
                e.preventDefault();
                getEmptyLegs('');
                window.history.pushState("", "", window.location.href.split('?')[0]);
            }).on("cancel.daterangepicker", function(e, picker) {
                if(e.keyCode == 8 || e.keyCode == 46) {
                    picker.element.val('');
                }
            });

            $('#startPointName, #endPointName, #flightDate').on("keyup change", function (e) {
                if ($('#startPointName').val().length >= 3 || $('#endPointName').val().length >= 3 || $('#flightDate').val().length > 0) {
                    e.preventDefault();
                    getEmptyLegs('');
                    window.history.pushState("", "", window.location.href.split('?')[0]);
                }
            });

            $('#startPointName').on('keydown', function(e) {
                if( e.which == 8 || e.which == 46 ) {
                    e.preventDefault();
                    $('#startPointName').val('');
                    getEmptyLegs('');
                    window.history.pushState("", "", window.location.href.split('?')[0]);
                }
            });

            $('#endPointName').on('keydown', function(e) {
                if( e.which == 8 || e.which == 46 ) {
                    e.preventDefault();
                    $('#endPointName').val('');
                    getEmptyLegs('');
                    window.history.pushState("", "", window.location.href.split('?')[0]);
                }
            });

            $(document).on('click', '.pagination  a', function (e) {
                if ($('#startPointName').val().length >= 3 || $('#endPointName').val().length >= 3 || $('#flightDate').val().length > 0) {
                    e.preventDefault();
                    let url = $(this).attr('href');
                    getEmptyLegs(url.split('?page=')[1]);
                    window.history.pushState("", "", url);
                    return false;
                }
                return true;
            });

            function getEmptyLegs(page) {
                let startPointName = $('#startPointName').val();
                let endPointName = $('#endPointName').val();
                let flightDate = $('#flightDate').val();
                let _token = $('input[name="_token"]').val();
                /*let _token = $('meta[name="csrf-token"]').attr('content');*/

                $.ajax({
                    /*url: '?page=' + page + '&startPointName=' + startPointName + '&endPointName=' + endPointName +' &flightDate=' + flightDate + '&_token=' + _token,*/
                    url: '?page=' + page,
                    method: 'GET',
                    datatype: 'html',
                    async: false,
                    data: {
                        startPointName: startPointName,
                        endPointName: endPointName,
                        flightDate: flightDate,
                        _token: _token
                    }
                }).done(function (data) {
                   $('#search').html($.parseHTML(data));
                }).fail(function () {
                    $('#search').html('<div class="text-center">No matches found</div>');
                });
            }


            $('#pax').on("keyup change", function (e) {
                if($('#pax').val().length > 0) {
                    $('.search-error').remove();
                    $('input[name=passengers]').val($('#pax').val());
                    $('input[name=pax]').val($('#pax').val());
                    e.preventDefault();
                }
            });
/*
            $(document).on("click",".price-empty-leg-submit, .request-empty-leg-submit",function(e){

                let passengers = $('#pax').val();
                let html_message = '<span class="search-error">This field is required.</span>';

                if(passengers.length <= 0){
                    $('.search-error').remove();
                    $('#pax').parent('div').append(html_message);
                    $('html, body').animate({
                        scrollTop: parseInt($('.search-error').offset().top)
                    }, 500);
                    $('#pax').focus();
                    e.preventDefault();
                }
            });
            */
        });
    </script>
@endpush
