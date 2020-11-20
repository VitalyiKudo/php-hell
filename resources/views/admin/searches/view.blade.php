@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.searches.index') }}">Searches</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $search->id }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            
            <div class="row mb-3">
                <div class="col-md-12">
                    @include('admin.searches.result-card', ['search' => $search])
                </div>
            </div>
            
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Search details</h5>
                    <h6 class="card-subtitle mb-3 text-muted">General information</h6>
    
                    <dl class="mb-0">
                        <dt>ID</dt>
                        <dd>{{ $search->id }}</dd>

                        <dt>Search ID</dt>
                        <dd>{{ $search->search_id }}</dd>

                        <dt>Searched at</dt>
                        <dd class="mb-0">{{ $search->created_at->format('d.m.Y G:h') }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">User details</h5>
                    <h6 class="card-subtitle mb-3 text-muted">General information</h6>
                    
                    @if (! is_null($search->user))
                        <dl>
                            <dt>Name</dt>
                            <dd>{{ $search->user->full_name }}</dd>

                            <dt>Email</dt>
                            <dd>{{ $search->user->email }}</dd>
                        </dl>

                        <a href="{{ route('admin.users.show', $search->user->id) }}">View details</a>
                    @else
                        <div class="alert alert-primary">The search is not associated with any user.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
