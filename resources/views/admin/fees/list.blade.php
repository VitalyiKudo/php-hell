@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Additional Fees</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.fees.create') }}" class="btn btn-primary">Add new</a>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12" id="fetch-list">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Additional Fees</h5>
                    <h6 class="card-subtitle mb-3 text-muted">The list of fees</h6>
                    
                    @if ($feeses->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover table-vertical-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="align-middle">#</th>
                                        <th class="align-middle">Item</th>
                                        <th class="align-middle">Amount</th>
                                        <th class="align-middle">Type</th>
                                        <th class="align-middle">Active</th>
                                        <th class="align-middle">Discount</th>
                                        <th class="align-middle">Created at</th>
                                        <th class="align-middle"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($feeses as $fees)
                                        <tr>
                                            <td class="align-middle">{{ $loop->iteration }}</td>
                                            <td class="align-middle">{{ $fees->item }}</td>
                                            <td class="align-middle">{{ $fees->amount }}</td>
                                            <td class="align-middle">{{ $fees->type }}</td>
                                            <td class="align-middle {{ $fees->active ? 'text-success' : 'text-danger' }}">{{ $fees->active ? 'Yes' : 'No' }}</td>
                                            <td class="align-middle {{ $fees->sall ? 'text-success' : 'text-danger' }}">{{ $fees->sall ? 'Yes' : 'No' }}</td>
                                           
                                            <td class="align-middle">{{ $fees->created_at->format('m-d-Y H:i') }}</td>
                                            <td class="align-middle text-right">
                                                <a href="{{ route('admin.fees.edit', $fees->id) }}" class="btn btn-secondary btn-sm">
                                                    Edit
                                                </a>
                                                <a href="{{ route('admin.fees.show', $fees->id) }}" class="btn btn-secondary btn-sm">
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

            {{ $feeses->links() }}
        </div>
        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    </div>
</div>

@endsection
