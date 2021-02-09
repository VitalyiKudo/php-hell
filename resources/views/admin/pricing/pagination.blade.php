<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Pricing</h5>
        <h6 class="card-subtitle mb-3 text-muted">The list of pricings</h6>

        @if ($pricing->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover table-vertical-middle mb-0">
                    <thead>
                        <tr>
                            <th class="align-middle">#</th>
                            <th class="align-middle">Departure</th>
                            <th class="align-middle">Arrival</th>
                            <th class="align-middle">Price Turbo-prop</th>
                            <th class="align-middle">Price Light</th>
                            <th class="align-middle">Price Medium</th>
                            <th class="align-middle">Price Heavy</th>
                            <th class="align-middle">Created at</th>
                            <th class="align-middle"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($pricing as $price)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>

                                <td class="align-middle">{{ $price->departure }}</td>
                                <td class="align-middle">{{ $price->arrival }}</td>
                                <td class="align-middle">{{ number_format($price->price_turbo, 2, '.', ' ') }} &euro;</td>

                                <td class="align-middle">{{ number_format($price->price_light, 2, '.', ' ') }} &euro;</td>
                                <td class="align-middle">{{ number_format($price->price_medium, 2, '.', ' ') }} &euro;</td>
                                <td class="align-middle">{{ number_format($price->price_heavy, 2, '.', ' ') }} &euro;</td>

                                <td class="align-middle">{{ Carbon\Carbon::parse($price->created_at)->format('d.m.Y H:i') }}</td>
                                <td class="align-middle text-right">
                                    <a href="{{ route('admin.pricing.edit', $price->id) }}" class="btn btn-secondary btn-sm">
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.pricing.show', $price->id) }}" class="btn btn-secondary btn-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-primary mb-0">
                The list of fleets is empty.
            </div>
        @endif
    </div>
</div>

{{ $pricing->links() }}
