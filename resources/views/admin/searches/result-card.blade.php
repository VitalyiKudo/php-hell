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

        </dl>
    </div>
</div>
