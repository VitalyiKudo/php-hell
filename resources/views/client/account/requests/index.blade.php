@extends('client.layouts.app')
@section('meta')
<title>Requests | JetOnset</title>
@endsection

@section('content')
<div class="container header-page-image"></div>

<div class="container request-page">
    <div class="row">

        <!--
        <div class="col-lg-4">
            <h2 class="mb-4 left-request-title">Requests</h2>
            <div class="left-request">
                <p class="mb-3">Sort search request by</p>

                <p class="dropdown-label mb-0">Status</p>
                <select class="selectpicker mb-3" data-width="100%">
                    <option>Active</option>
                    <option>Active</option>
                    <option>Active</option>
                </select>

                <p class="dropdown-label mb-0">Area</p>
                <select class="selectpicker mb-3" data-width="100%">
                    <option>America</option>
                    <option>America</option>
                    <option>America</option>
                </select>

                <p class="dropdown-label mb-0">Date</p>
                <div class="calendar mb-0"></div>
            </div>
        </div>
        -->

        <div class="offset-xl-2 offset-lg-2    col-xl-10 col-lg-10    right-request">
            <h2 class="mb-5">Overview of your requests</h2>

            <p class="card-title mb-5"><span>{{ $requests->total() }}</span> results are available</p>

            @foreach ($requests as $request)
                <div class="card mb-4 request-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto col-sm-auto col-md-auto mr-2"><span class="request-number">{{ $loop->iteration + $requests->firstItem() - 1 }}</span></div>
                            {{--}}<div class="col-2 col-sm-2 col-md-2">
                                <div class="silver-info mb-2">Order number</div>
                                <div class="center-bold">{{ $request->id }}</div>
                                <div class="silver-info">{{ Carbon\Carbon::parse($request->created_at)->format('m/d/Y') }}</div>
                            </div>--}}
                            <div class="col-2 col-sm-2 col-md-2">
                                <div class="silver-info mb-2">From Airport</div>
                                <div class="center-bold">{{ $request->searches->departureCity->name }}</div>
                                {{--}}<div class="silver-info">{{ Carbon\Carbon::parse($request->searches->departure_at)->format('m/d/Y') }}</div>--}}
                                <div class="silver-info">&nbsp;</div>
                            </div>
                            <div class="col-auto col-sm-auto col-md-auto mr-2">
                                <div class="silver-info">&nbsp;</div>
                                <img src="/images/plan-icon.svg" alt="plan icon">
                                <div class="silver-info">&nbsp;</div>
                                <div class="silver-info">{{ Carbon\Carbon::parse($request->searches->departure_at)->format('m/d/Y') }}</div>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2">
                                <div class="silver-info mb-2">To Airport</div>
                                <div class="center-bold">{{ $request->searches->arrivalCity->name }}</div>
                                {{--}}<div class="silver-info">{{ Carbon\Carbon::parse($request->searches->created_at)->format('m/d/Y') }}</div>--}}
                                <div class="silver-info">&nbsp;</div>
                            </div>
                            <div class="col-auto col-sm-auto col-md-auto mr-2">
                                {{--}}<div class="d-block d-sm-block d-md-none mt-4"></div>--}}
                                <div class="silver-info mb-1">PASS.</div>
                                <div class="center-bold">{{ $request->searches->pax }}</div>
                                <div class="silver-info">&nbsp;</div>
                            </div>
                            <div class="col-auto col-sm-auto col-md-auto">
                                {{--}}<div class="d-block d-sm-block d-md-none mt-4"></div>--}}
                                <div class="silver-info mb-2">Price (Incl. taxes)</div>
                                <div class="center-bold">${{ number_format($request->price,2) }}</div>
                                <div class="silver-info">&nbsp;</div>
                            </div>
                            <div class="col-auto col-sm-auto col-md-auto book">
                                <a href="{{ route('client.orders.square', [$request->search_result_id, $request->type] ) }}" class="{{ ($request->price > 0 && $request->order_status_id == 3) ? 'btn' : 'isDisabled' }} justify-content-end">
                                {{($request->price > 0 && $request->order_status_id == 3) ? "Book now" : "In progress"}}
                                </a>
                            </div>
                        </div>
{{--}}
                        @if (createAdditionalDataArray($request->comment, 'from_stop_airport') || createAdditionalDataArray($request->comment, 'to_stop_airport'))
                        <hr>
                        <div class="row align-items-center">
                            <div class="col-1 col-sm-1 col-md-1"></div>
                            <div class="col-5 col-sm-2 col-md-2 country">
                                <div class="silver-info mb-2">FROM STOP AIRPORT</div>
                                <div class="center-bold">{{ createAdditionalDataArray($request->comment, 'from_stop_airport') }}</div>
                                <div class="silver-info">{{ Carbon\Carbon::parse(createAdditionalDataArray($request->comment, 'stop_date'))->format('m/d/Y') }}</div>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1"></div>
                            <div class="col-5 col-sm-2 col-md-2 country">
                                <div class="silver-info mb-2">TO STOP AIRPORT</div>
                                <div class="center-bold">{{ createAdditionalDataArray($request->comment, 'to_stop_airport') }}</div>
                                <div class="silver-info">{{ Carbon\Carbon::parse(createAdditionalDataArray($request->comment, 'stop_date'))->format('m/d/Y') }}</div>
                            </div>
                            <div class="col-6 col-sm-2 col-md-1"></div>
                            <div class="col-6 col-sm-2 col-md-2"></div>
                            <div class="col-12 col-sm-12 col-md-3 book"></div>
                        </div>
                        @endif

                        @if (createAdditionalDataArray($request->comment, 'from_return_airport') || createAdditionalDataArray($request->comment, 'to_return_airport'))
                        <hr>
                        <div class="row align-items-center">
                            <div class="col-1 col-sm-1 col-md-1"></div>
                            <div class="col-5 col-sm-5 col-md-2">
                                <div class="silver-info mb-2">FROM RETURN AIRPORT</div>
                                <div class="center-bold">{{ createAdditionalDataArray($request->comment, 'from_return_airport') }}</div>
                                <div class="silver-info">{{ Carbon\Carbon::parse(createAdditionalDataArray($request->comment, 'return_date'))->format('m/d/Y') }}</div>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1">
                                <img src="/images/plan-icon-return.svg" alt="plan icon">
                            </div>
                            <div class="col-5 col-sm-5 col-md-2">
                                <div class="silver-info mb-2">TO RETURN AIRPORT</div>
                                <div class="center-bold">{{ createAdditionalDataArray($request->comment, 'to_return_airport') }}</div>
                                <div class="silver-info">{{ Carbon\Carbon::parse(createAdditionalDataArray($request->comment, 'return_date'))->format('m/d/Y') }}</div>
                            </div>
                            <div class="col-6 col-sm-6 col-md-1"></div>
                            <div class="col-6 col-sm-6 col-md-2"></div>
                            <div class="col-12 col-sm-12 col-md-3 book"></div>
                        </div>
                        @endif
--}}
                    </div>
                </div>
            @endforeach

            {{ $requests->links() }}

        </div>
    </div>
</div>
@endsection

