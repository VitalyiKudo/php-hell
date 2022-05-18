@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.emptyLegs.index') }}">Empty Legs</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $emptyLeg['dateDeparture']->format('m-d-Y') }}  ({{ $emptyLeg['operatorName'] }})</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>View Empty Leg</h3>

                    <div class="card">
                        <div class="card-body">

                            <dl class="mb-0">
                                <dt>Departure Date</dt>
                                <dd>{{ $emptyLeg['dateDeparture']->format('m-d-Y') }}</dd>

                                <dt>Departure Airport</dt>
                                <dd>{{ $emptyLeg['airportDeparture'] }}  ({{ $emptyLeg['icaoDeparture'] }})</dd>

                                <dt>Arrival Airport</dt>
                                <dd>{{ $emptyLeg['airportArrival'] }}  ({{ $emptyLeg['icaoArrival'] }})</dd>

                                <dt>Operator</dt>
                                <dd>{{ $emptyLeg['operatorName'] }}  ({{ $emptyLeg['operatorEmail'] }})</dd>

                                <dt>Price</dt>
                                <dd>{{ $emptyLeg['price'] }}</dd>

                                <dt>Status</dt>
                                <dd><span class="badge {{ array_search($emptyLeg['active'], $status['statusBg']) }}">{{ array_search($emptyLeg['active'], $status['status']) }}</span></dd>

                            </dl>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
</div>
@endsection
