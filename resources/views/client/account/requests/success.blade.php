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
                                        >
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
                                        >
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" id="arrival-airport">
                                            <img src="/images/arrival-icon.svg" class="icon-img" alt="..."></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 mt-2 ml-3" style="width: 19% !important">
                                    <div class="input-group input-style">
                                        <input type="text" class="form-control " name="departure" placeholder="Date&Time">
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
                                        <input type="number" class="form-control bd-input" placeholder="Passengers" aria-describedby="passengers" name="passengers">

                                    </div>
                                </div>

                                <div class="form-container-1 mt-2 ml-3" style="width:11% !important">
                                    <button type="submit" class="btn">Search Jet</button>
                                </div>
                            </div>
                        </form>
                        
                        
                    
                    
                    
                </div>
            

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">

                            @if (session('status'))
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    </div>
                                </div>
                            @endif

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
@endsection

