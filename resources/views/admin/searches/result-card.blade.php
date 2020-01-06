<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            @if (isset($iteration))
                (#{{ $iteration }})
            @endif

            {{ $result->result_id }}
        </h5>
        <h6 class="card-subtitle mb-3 text-muted">The search result details</h6>

        <dl class="mb-0">
            <dt>Seller Name</dt>
            <dd>{{ $result->seller_name }}</dd>

            <dt>Seller ICAO</dt>
            <dd>{{ $result->seller_icao }}</dd>

            <dt>Lift ID</dt>
            <dd>{{ $result->lift_id }}</dd>

            <dt>Aircraft Category</dt>
            <dd>{{ $result->aircraft_category }}</dd>

            <dt>Aircraft Type</dt>
            <dd>{{ $result->aircraft_type }}</dd>

            <dt>Segments Count</dt>
            <dd>{{ $result->segments->count() }}</dd>

            <dt>Price</dt>
            <dd class="mb-0">
                {{ number_format($result->price, 2, '.', ' ') }}
                {{ $result->currency }}
            </dd>
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
                        <th>Start Airport ID</th>
                        <th>Start Airport Name</th>
                        <th>Start Airport City</th>
                        <th>Start Airport Country</th>
                        <th>Start Airport ICAO</th>
                        <th>Start Airport IATA</th>
                        <th>End Airport ID</th>
                        <th>End Airport Name</th>
                        <th>End Airport City</th>
                        <th>End Airport Country</th>
                        <th>End Airport ICAO</th>
                        <th>End Airport IATA</th>
                        <th>Block minutes</th>
                        <th>Flight minutes</th>
                        <th>Fuel minutes</th>
                        <th>Distance NM</th>
                        <th>Departure at</th>
                        <th>Arrival at</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($result->segments as $segment)
                        <tr>
                            <td>{{ $segment->start_airport_id }}</td>
                            <td>{{ $segment->start_airport_name }}</td>
                            <td>{{ $segment->start_airport_city }}</td>
                            <td>{{ $segment->start_airport_country_name }}</td>
                            <td>{{ $segment->start_airport_icao }}</td>
                            <td>{{ $segment->start_airport_iata }}</td>
                            <td>{{ $segment->end_airport_id }}</td>
                            <td>{{ $segment->end_airport_name }}</td>
                            <td>{{ $segment->end_airport_city }}</td>
                            <td>{{ $segment->end_airport_country_name }}</td>
                            <td>{{ $segment->end_airport_icao }}</td>
                            <td>{{ $segment->end_airport_iata }}</td>
                            <td>{{ $segment->block_minutes }}</td>
                            <td>{{ $segment->flight_minutes }}</td>
                            <td>{{ $segment->fuel_minutes }}</td>
                            <td>{{ $segment->distance_nm }}</td>
                            <td>{{ $segment->departure_at->format('d.m.Y G:h') }}</td>
                            <td>{{ $segment->arrival_at->format('d.m.Y G:h') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
