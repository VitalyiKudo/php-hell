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
                    <h3>Edit Order</h3>
                    <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Change Order Status</h5>
                    <dl class="mb-0">
                        <div class="form-group">
                        
                    @if($order->is_accepted == null)
                        <div class="form-group">
                            <form class="mt-3" action="{{ route('admin.orders.accepted') }}" method="POST">
                                @csrf
                                <div class="custom-control custom-radio">
                                    <input value="1" name="accept" type="radio" class="custom-control-input" id="customControlValidation2" >
                                    <label class="custom-control-label" for="customControlValidation2">Accept</label>
                                </div>
                                <div class="custom-control custom-radio mb-3">
                                    <input value="0" name="accept" type="radio" class="custom-control-input" id="customControlValidation3" >
                                    <label class="custom-control-label" for="customControlValidation3">Decline</label>
                                </div>
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <button type="submit" class="btn btn-sm btn-success">Save</button>
                            </form>    
                        </div>
                    @elseif($order->is_accepted)     
                        <dt>
                            <form class="mt-3" action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                @method('PUT')
                                @csrf

                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" 
                                        id="price" name="price" value="{{ $order->price }}" required>

                                    @if ($errors->has('price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @endif
                                </div>



                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Select Status</label>

                                        <select class="form-control" name="order_status" id="exampleFormControlSelect1">
                                            @foreach($orderStatuses as $stauts)
                                                <option {{($order->status->id== $stauts->id ? 'selected' : '' ) }} value="{{ $stauts->id}}">{{ $stauts->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                
                                
                                
                                
                                <div class="form-group">
                                    <label for="formControlOperator">Select Operator</label>

                                    <select class="form-control" name="operator" id="formControlOperator">
                                        <option value="0"> -- Select Operator -- </option>
                                        @foreach($operators as $operator)
                                            <option {{($order->operator_id == $operator->id ? 'selected' : '' ) }} value="{{$operator->id}}">{{ $operator->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                                </div>
                                
                            </form>
                        </dt>

                    @endif    
                    </dl>
                </div>
            </div>    

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

        <div class="col-md-4 mt-5">
            
        </div>
    </div>
</div>
@endsection


