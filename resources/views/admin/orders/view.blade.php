@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.searches.index') }}">Orders</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">#{{ $order->id }}</li>
                </ol>
            </nav>
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
        <div class="col-md-8">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>Selected result</h3>

                    @include('admin.searches.result-card', ['result' => $order->searches])

                    <!-- <form class="mt-3">
                        <button type="submit" class="btn btn-success">Accept</button>
                        <button type="submit" class="btn btn-danger">Decline</button>
                    </form> -->
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-3">
        <br>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Order details</h5>
                    <h6 class="card-subtitle mb-3 text-muted">General information</h6>
    
                    <dl class="mb-0">
                        <dt>ID</dt>
                        <dd>{{ $order->id }}</dd>

                        <dt>Status</dt>
                        <dd>
                        @if(is_null($order->is_accepted))
                                <span class="badge badge-pill badge-warning">
                                    Awaiting for Acceptance
                                </span>
                            @elseif ($order->is_accepted == 1)
                                <span class="badge badge-pill badge-success">
                                    Accepted
                                </span>  
                                <span class="badge badge-pill badge-{{ $order->status->style }}">
                                    {{ $order->status->name }} 
                                </span>
                            @else
                                <span class="badge badge-pill badge-danger">
                                    Declined
                                </span>
                            @endif
                        </dd>

                        <dt>Price</dt>
                        <dd>{{ number_format($order->price, 2, '.', ' ') }} &euro;</dd>

                        <dt>Created at</dt>
                        <dd class="mb-0">{{ $order->created_at->format('d.m.Y G:h') }}</dd>
                        
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">User details</h5>
                    <h6 class="card-subtitle mb-3 text-muted">General information</h6>

                    <dl>
                        <dt>Name</dt>
                        <dd>{{ $order->user->full_name }}</dd>
                        
                        @if ($order->user->phone_number)
                            <dt>Phone number</dt>
                            <dd>{{ $order->user->phone_number }}</dd>
                        @endif

                        <dt>Email</dt>
                        <dd>{{ $order->user->email }}</dd>
                    </dl>

                    <a href="{{ route('admin.users.show', $order->user->id) }}">View details</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
