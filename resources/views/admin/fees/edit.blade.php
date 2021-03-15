@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.fees.index') }}">Additional Fees</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.fees.edit', $fees->id) }}">{{ $fees->item }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $fees->departure_city }}</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Edit Additional Fees</h6>

                    <form method="POST" action="{{ route('admin.fees.update', $fees->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="item">Item</label>
                            <input type="text" class="form-control{{ $errors->has('item') ? ' is-invalid' : '' }}" id="item" name="item" value="{{ old('item', $fees->item) }}" autocomplete="off" required>
                            
                            @if ($errors->has('item'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('item') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" step="any" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" id="amount" name="amount" value="{{ old('amount', $fees->amount) }}">

                            @if ($errors->has('amount'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="type">Type</label>

                            <select name="type" id="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}">
                                <option {{ old('type', $fees->type) == "$" ? 'selected':'' }}>$</option>
                                <option {{ old('type', $fees->type) == "%" ? 'selected':'' }}>%</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="active">Active</label>

                            <select name="active" id="active" class="form-control{{ $errors->has('active') ? ' is-invalid' : '' }}">
                                <option value="1" {{ old('active', $fees->active) == 1 ? 'selected':'' }}>Activated</option>
                                <option value="0" {{ old('active', $fees->active) == 0 ? 'selected':'' }}>Deactivated</option>
                            </select>
                        </div>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sall" value="1" id="sall" {{ old('sall', $fees->sall) == 1 ? 'checked':'' }} >
                            <label for="sall">Sall</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Delete Additional Fees</h5>

                    <form method="POST" action="{{ route('admin.fees.destroy', $fees->id) }}">
                        @csrf
                        @method('DELETE')

                        <p>Are you sure you want to delete this additional fees? This action cannot be undone.</p>

                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this additional fees? This action cannot be undone.')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
