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
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">New airline</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Fill the details of a new airline</h6>

                    <form method="POST" action="{{ route('admin.airlines.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="type">Type</label>
                            <input type="text" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" id="type" name="type" value="{{ old('type') }}" required>

                            @if ($errors->has('type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="reg_number">Reg. number</label>
                            <input type="text" class="form-control{{ $errors->has('reg_number') ? ' is-invalid' : '' }}" id="reg_number" name="reg_number" value="{{ old('reg_number') }}" required>

                            @if ($errors->has('reg_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('reg_number') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" id="category" name="category" value="{{ old('category') }}" required>

                            @if ($errors->has('category'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="homebase">Homebase</label>
                            <input type="text" class="form-control{{ $errors->has('homebase') ? ' is-invalid' : '' }}" id="homebase" name="homebase" value="{{ old('homebase') }}" required>

                            @if ($errors->has('homebase'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('homebase') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="max_pax">Max PAX</label>
                            <input type="number" min="0" class="form-control{{ $errors->has('max_pax') ? ' is-invalid' : '' }}" id="max_pax" name="max_pax" value="{{ old('max_pax') }}" required>

                            @if ($errors->has('max_pax'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('max_pax') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="yom">YOM</label>
                            <input type="number" min="0" class="form-control{{ $errors->has('yom') ? ' is-invalid' : '' }}" id="yom" name="yom" value="{{ old('yom') }}" required>

                            @if ($errors->has('yom'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('yom') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="operator">Operator</label>
                            <input type="text" class="form-control{{ $errors->has('operator') ? ' is-invalid' : '' }}" id="operator" name="operator" value="{{ old('operator') }}" required>

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
</div>
@endsection
