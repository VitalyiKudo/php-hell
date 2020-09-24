@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.airlines.index') }}">Airlines</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.airlines.edit', $airline->id) }}">{{ $airline->type }}</a>
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
                    <h5 class="card-title">{{ $airline->name }}</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Edit airline</h6>

                    <form method="POST" action="{{ route('admin.airlines.update', $airline->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="type">Type</label>
                            <input type="text" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" id="type" name="type" value="{{ old('type', $airline->type) }}" required>

                            @if ($errors->has('type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="reg_number">Reg. number</label>
                            <input type="text" class="form-control{{ $errors->has('reg_number') ? ' is-invalid' : '' }}" id="reg_number" name="reg_number" value="{{ old('reg_number', $airline->reg_number) }}">

                            @if ($errors->has('reg_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('reg_number') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" id="category" name="category" value="{{ old('category', $airline->category) }}">

                            @if ($errors->has('category'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="homebase">Homebase</label>
                            <input type="text" class="form-control{{ $errors->has('homebase') ? ' is-invalid' : '' }}" id="homebase" name="homebase" value="{{ old('homebase', $airline->homebase) }}">

                            @if ($errors->has('homebase'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('homebase') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="max_pax">Max PAX</label>
                            <input type="number" min="0" class="form-control{{ $errors->has('max_pax') ? ' is-invalid' : '' }}" id="max_pax" name="max_pax" value="{{ old('max_pax', $airline->max_pax) }}">

                            @if ($errors->has('max_pax'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('max_pax') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="yom">YOM</label>
                            <input type="number" min="0" class="form-control{{ $errors->has('yom') ? ' is-invalid' : '' }}" id="yom" name="yom" value="{{ old('yom', $airline->yom) }}">

                            @if ($errors->has('yom'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('yom') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="operator">Operator</label>
                            <input type="text" class="form-control{{ $errors->has('operator') ? ' is-invalid' : '' }}" id="operator" name="operator" value="{{ old('operator', $airline->operator) }}">

                            @if ($errors->has('operator'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('operator') }}</strong>
                                </span>
                            @endif
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
                    <h5 class="card-title">Delete airport</h5>

                    <form method="POST" action="{{ route('admin.airlines.destroy', $airline->id) }}">
                        @csrf
                        @method('DELETE')

                        <p>Are you sure you want to delete this airline? This action cannot be undone.</p>

                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this airline? This action cannot be undone.')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
