@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.fees.index') }}">Pricing</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">New pricing</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Fill the details of a new pricing</h6>

                    <form method="POST" action="{{ route('admin.fees.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="item">Item</label>
                            <input type="text" class="form-control{{ $errors->has('item') ? ' is-invalid' : '' }}" id="item" name="item" value="{{ old('item') }}" autocomplete="off" required>

                            @if ($errors->has('item'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('item') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" id="amount" name="amount" value="{{ old('amount') }}">

                            @if ($errors->has('amount'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="type">Type</label>

                            <select name="type" id="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}">
                                <option>$</option>
                                <option>%</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="active">Active</label>

                            <select name="active" id="active" class="form-control{{ $errors->has('active') ? ' is-invalid' : '' }}">
                                <option value="1">Activated</option>
                                <option value="0">Deactivated</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
