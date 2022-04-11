@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Administrators</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.administrators.create') }}" class="btn btn-primary">Add new</a>
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
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Administrators</h5>
                    <h6 class="card-subtitle mb-3 text-muted">The list of administrators</h6>
                    
                    <div class="table-responsive">
                        <table class="table table-hover table-vertical-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($administrators as $administrator)
                                    <tr>
                                        <td>{{ $loop->iteration + $administrators->firstItem() - 1 }}</td>
                                        <td>{{ $administrator->name }}</td>
                                        <td>{{ $administrator->email }}</td>
                                        <td>{{ $administrator->created_at->format('m-d-Y H:i') }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.administrators.edit', $administrator->id) }}" class="btn btn-secondary btn-sm">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{ $administrators->links() }}
        </div>
    </div>
</div>
@endsection
