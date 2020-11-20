@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Searches</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Searches</h5>
                    <h6 class="card-subtitle mb-3 text-muted">The list of searches</h6>

                    <table class="table table-hover table-vertical-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Search ID</th>
                                <th>User</th>
                                
                                <th>Created at</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($searches as $search)
                                <tr>
                                    <td>{{ $loop->iteration + $searches->firstItem() - 1 }}</td>
                                    <td>{{ $search->id }}</td>
                                    <td>
                                        @if (! is_null($search->user))
                                            <a href="{{ route('admin.users.show', $search->user->id) }}">{{ $search->user->full_name }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $search->created_at->format('d.m.Y H:i') }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.searches.show', $search->id) }}" class="btn btn-secondary btn-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{ $searches->links() }}
        </div>
    </div>
</div>
@endsection
