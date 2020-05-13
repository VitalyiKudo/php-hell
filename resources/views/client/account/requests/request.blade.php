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

{{--                <p class="card-title"><span>3</span> results are available</p>--}}

                @foreach ($searchResults->data->results as $flight)

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">

                                <div class="col-md-auto green-box"></div>
{{--                                --}}
{{--                                <div class="col-md-auto red-box"></div>--}}

{{--                                <div class="col-md-auto yellow-box"></div>--}}

                                <div class="col-md-2 icao">
                                    <p> {{ $flight->quote->segments[0]->startAirport->iata. ' - '.$flight->quote->segments[0]->endAirport->iata }}</p>
                                    <p> {{ \Carbon\Carbon::parse($flight->quote->segments[0]->departureDateTime->dateTimeUTC)->format('H:i') 
                                            . ' - '.   
                                        
                                            \Carbon\Carbon::parse($flight->quote->segments[0]->arrivalDateTime->dateTimeUTC)->format('H:i') }} </p>    
                                </div>
                                <div class="col-md-3 country"></div>
                                <div class="col-md-2 date">
                                    {{ \Carbon\Carbon::parse($flight->quote->segments[0]->departureDateTime->dateTimeUTC)->format('Y-m-d')  }}
                                </div>
                                <div class="col-md-2 price">
                                    {{ $flight->quote->sellerPriceWithoutCommission->currency .' '.$flight->quote->sellerPriceWithoutCommission->price }}
                                </div>
                                <div class="col-md-2 book">
                                    <a href="#" class="btn">Request again</a>
                                </div>
                                <div class="col-md-auto arrow">▼</div>
                            </div>
                        </div>
                    </div>
                    @if($loop->iteration == 15)
                        @break
                    @endif
                @endforeach

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

