@extends('client.layouts.app')
@section('meta')
<title>Orders | JetOnset</title>
@endsection

@section('content')
<div class="container header-page-image"></div>

<div class="container order-page">
    <div class="row">

        <div class="offset-xl-2 col-xl-10 col-lg-10 right-order">
            <h2 class="mb-5">Overview of your orders</h2>

            <p class="card-title"><span>{{ $orders->total() }}</span> results are available</p>

            @foreach ($orders as $order)
                <div class="card mb-4 order-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            
                            <div class="col-6 col-sm-6 col-md-6 order-number">Order № {{ $order->order_id }}</div>
                            <div class="col-6 col-sm-6 col-md-6 text-right">Status: <span class="status-{{ $order->code }}">{{ removeBottomSlash($order->code) }}</span></div>
                            <div class="col-12 col-sm-12 col-md-12 order-block-title">route &amp; AIRCRAFT</div>
                            <div class="col-12 col-sm-12 col-md-12"><hr></div>
                            <div class="col-12 col-sm-12 col-md-4 pr-0">
                                <div class="silver-info mt-3">From Airport</div>
                                <div class="order-start-airport mb-3 mt-1">{{ $order->start_airport_name }}</div>
                                <div class="silver-info">departure date <span>{{ Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</span></div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 pl-0">
                                <div class="silver-info mt-3">To Airport</div>
                                <div class="order-finish-airport mb-3 mt-1">{{ $order->end_airport_name }}</div>
                                <div class="silver-info">arrival date <span>{{ Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</span></div>
                            </div>
                            <div class="d-none d-sm-none d-md-block col-md-2"></div>
                            <div class="col-12 col-sm-12 col-md-2">
                                <div class="silver-info mt-3">Price</div>
                                <div class="order-price-field mb-3 mt-1">{{ $order->price }} &euro;</div>
                                <div class="silver-info">&nbsp;</div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 options-wrapper">

                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-8 mt-4 order-block-title">PASSENGERS &amp; baGGAGE</div>
                                    <div class="col-4 col-sm-4 col-md-4 mt-4 order-block-title d-none d-sm-none d-md-block">extra</div>
                                    <div class="col-12 col-sm-12 col-md-12"><hr></div>
                                    
                                    <div class="col-6 col-sm-6 col-md-4">
                                        <p><span class="silver-info">Passengers:</span> {{ $order->pax }}</p>
                                        <p><span class="silver-info">PETS:</span> {{ createAdditionalDataArray($order->comment, 'pets') ?: '-' }}</p>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-4">
                                        <p><span class="silver-info">bagS:</span> {{ createAdditionalDataArray($order->comment, 'bags') ?: '-' }}</p>
                                        <p><span class="silver-info">large baggage:</span> {{ createAdditionalDataArray($order->comment, 'large_baggage') ?: '-' }}</p>
                                    </div>
                                    
                                    <div class="col-12 col-sm-12 col-md-12 mt-4 order-block-title d-sm-block d-md-none">extra</div>
                                    <div class="col-12 col-sm-12 col-md-12 d-sm-block d-md-none"><hr></div>

                                    <div class="col-12 col-sm-12 col-md-4">
                                        <p><span class="silver-info">extra options:</span> 
                                        {{ createAdditionalDataArrayRewerse($order->comment, ['Wi-Fi', 'Lavatory', 'People with disabilities', 'Catering']) ?: '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 mt-3 order-block-title">AIRCRAFT &amp; flight operator</div>
                                    <div class="col-12 col-sm-12 col-md-12"><hr></div>

                                    <div class="col-6 col-sm-6 col-md-4">
                                        <p><span class="silver-info">Type</span></p>
                                        <p>{{ $order->type ?: '-' }}</p>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-4">
                                        <p><span class="silver-info">aircraft</span></p>
                                        <p>{{ createAdditionalDataArray($order->comment, 'preffered_aircraft') ?: '-' }}</p>
                                        <p>{{ createAdditionalDataArray($order->comment, 'preffered_second_aircraft') }}</p>
                                        <p>{{ createAdditionalDataArray($order->comment, 'preffered_third_aircraft') }}</p>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-4">
                                        <p><span class="silver-info">flight operator</span></p>
                                        <p>{{ $order->name ?: '-' }}</p>
                                    </div>
                                    

                                    <div class="col-12 col-sm-12 col-md-12"><hr></div>
                                    <div class="col-12 col-sm-12 col-md-12">
                                        <p><span class="silver-info">comment:</span> {{ createAdditionalDataArray($order->comment, 'comment') ?: '-' }}</p>
                                    </div>

                                </div>

                            </div>

                            
                            <div class="col-12 col-sm-12 col-md-12 text-right">
                                <a href="#" class="order-show-more">show more</a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
            
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script type="text/javascript">
        $(function() {
            $(document).on('click', '.order-show-more', function(e){
                e.preventDefault();
                $(this).parent('div').parent('div').find('.options-wrapper').slideToggle(function(){
                    $(this).parent('div').find('.order-show-more').toggleClass('arrow-direction');
                    
                });
            });
        });
    </script>
@endpush