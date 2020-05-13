@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Orders</li>
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
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Orders</h5>
                    <h6 class="card-subtitle mb-3 text-muted">The list of orders</h6>

                    <table class="table table-hover table-vertical-middle mb-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Created at</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="align-middle">#{{ $order->id }}</td>
                                    <td class="align-middle">
                                        @if (! is_null($order->user))
                                            <a href="{{ route('admin.users.show', $order->user->id) }}">{{ $order->user->full_name }}</a>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-pill badge-{{ $order->status->style }}">{{ $order->status->name }}</span>
                                    </td>
                                    <td class="align-middle">{{ number_format($order->price, 2, '.', ' ') }} &euro;</td>
                                    <td class="align-middle">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                    
                                    <td class="align-middle text-right">
                                    <!-- {{ route('admin.orders.edit', $order->id) }} -->
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-secondary btn-sm">
                                            Edit
                                        </a>

                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary btn-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
