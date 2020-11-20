<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $search->result_id }}</h5>
        <h6 class="card-subtitle mb-3 text-muted">The search result details</h6>

        <dl class="mb-0">
            <dt>Departure Airport</dt>
            <dd>{{ $search->start_airport_name }}</dd>

            <dt>Arrival Airport</dt>
            <dd>{{ $search->end_airport_name }}</dd>

            <dt>Passengers:</dt>
            <dd>{{ $search->pax }}</dd>

            <dt>Date</dt>
            <dd>{{ Carbon\Carbon::parse($search->departure_at)->format('d.m.Y') }}</dd>
            
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
                        <td>{{ $order->comment }}</td>
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
