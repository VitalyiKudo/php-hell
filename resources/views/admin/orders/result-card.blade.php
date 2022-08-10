<div class="card">
    <div class="card-body">
        {{-- dd($order) --}}
        <h5 class="card-title">{{ $order->searches->result_id }}</h5>
        <h6 class="card-subtitle mb-3 text-muted">The search result details</h6>

        <dl class="mb-0">
            <dt>Departure Airport</dt>
            <dd>{{ $order->searches->start_airport_name }}</dd>

            <dt>Arrival Airport</dt>
            <dd>{{ $order->searches->end_airport_name }}</dd>

            <dt>Passengers:</dt>
            <dd>{{ $order->searches->pax }}</dd>

            <dt>Date</dt>
            <dd>{{ Carbon\Carbon::parse($order->searches->departure_at)->format('m-d-Y') }}</dd>

            <dt>Type</dt>
            <dd>{{ $order->type }}</dd>

            @if($pricing)
                @if($order->type == 'turbo')
                    <dt>Flight Time</dt>
                    <dd>{{ $pricing->time_turbo }}</dd>
                @elseif ($order->type == 'light')
                    <dt>Flight Time</dt>
                    <dd>{{ $pricing->time_light }}</dd>
                @elseif ($order->type == 'medium')
                    <dt>Flight Time</dt>
                    <dd>{{ $pricing->time_medium }}</dd>
                @elseif ($order->type == 'heavy')
                    <dt>Flight Time</dt>
                    <dd>{{ $pricing->time_heavy }}</dd>
                @else
                    <dt>Flight Time</dt>
                    <dd>00:00</dd>
                @endif
            @endif

            @if($operator)
            <dt>Operator</dt>
            <dd>{{ $operator->name }}</dd>
            @endif

        </dl>
    </div>
    <hr>
    <div class="card-body">
        <h5 class="card-title">Segments</h5>
        <h6 class="card-subtitle mb-3 text-muted">The result segments list</h6>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{!! nl2br($order->comment) !!}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Billing Address</th>
                        <th>Billing Address secondary</th>
                        <th>Billing Country</th>
                        <th>Billing City</th>
                        <th>Billing Province</th>
                        <th>Billing Postcode</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $order->billing_address }}</td>
                        <td>{{ $order->billing_address_secondary }}</td>
                        <td>{{ $order->billing_country }}</td>
                        <td>{{ $order->billing_city }}</td>
                        <td>{{ $order->billing_province }}</td>
                        <td>{{ $order->billing_postcode }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
