<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Operators</h5>
        <h6 class="card-subtitle mb-3 text-muted">The list of Operators</h6>

        @if ($operators->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover table-vertical-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Web-site</th>
                            <th>Created at</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($operators as $operator)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration + $operators->firstItem() - 1 }}</td>
                                <td class="align-middle">{{ $operator->name }}</td>
                                <td class="align-middle">{{ $operator->web_site }}</td>
                                <td class="align-middle">{{ Carbon\Carbon::parse($operator->created_at)->format('m-d-Y H:i') }}</td>
                                <td class="align-middle text-right">
                                    <a href="{{ route('admin.operators.edit', $operator->id) }}" class="btn btn-secondary btn-sm">
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.operators.show', $operator->id) }}" class="btn btn-secondary btn-sm">
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
                The list of operators is empty.
            </div>
        @endif
    </div>
</div>

{{ $operators->links() }}
