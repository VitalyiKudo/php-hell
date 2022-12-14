<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Fleet</h5>
        <h6 class="card-subtitle mb-3 text-muted">The list of fleets</h6>

        @if ($airlines->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover table-vertical-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Reg. number</th>
                            <th>Created at</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($airlines as $airline)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration + $airlines->firstItem() - 1 }}</td>
                                <td class="align-middle">{{ $airline->type }}</td>
                                <td class="align-middle">{{ $airline->reg_number }}</td>
                                <td class="align-middle">{{ Carbon\Carbon::parse($airline->created_at)->format('m-d-Y H:i') }}</td>
                                <td class="align-middle text-right">
                                    <a href="{{ route('admin.airlines.edit', $airline->id) }}" class="btn btn-secondary btn-sm">
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.airlines.show', $airline->id) }}" class="btn btn-secondary btn-sm">
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
                The list of airlines is empty.
            </div>
        @endif
    </div>
</div>

{{ $airlines->links() }}
