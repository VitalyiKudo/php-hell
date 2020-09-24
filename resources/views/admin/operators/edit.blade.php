@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.operators.index') }}">Operators</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.operators.edit', $operator->id) }}">{{ $operator->name }}</a>
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
                    <h5 class="card-title">{{ $operator->name }}</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Edit operator</h6>

                    <form method="POST" action="{{ route('admin.operators.update', $operator->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ old('name', $operator->name) }}" required>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="web_site">Web-site</label>
                            <input type="text" class="form-control{{ $errors->has('web_site') ? ' is-invalid' : '' }}" id="web_site" name="web_site" value="{{ old('web_site', $operator->web_site) }}">

                            @if ($errors->has('web_site'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('web_site') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email', $operator->email) }}">

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone', $operator->phone) }}">

                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" id="mobile" name="mobile" value="{{ old('mobile', $operator->mobile) }}">

                            @if ($errors->has('mobile'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="fax">Fax</label>
                            <input type="text" class="form-control{{ $errors->has('fax') ? ' is-invalid' : '' }}" id="fax" name="fax" value="{{ old('fax', $operator->fax) }}">

                            @if ($errors->has('fax'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fax') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" id="address" name="address" value="{{ old('address', $operator->address) }}">

                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
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
                    <h5 class="card-title">Delete operator</h5>

                    <form method="POST" action="{{ route('admin.operators.destroy', $operator->id) }}">
                        @csrf
                        @method('DELETE')

                        <p>Are you sure you want to delete this operator? This action cannot be undone.</p>

                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this operator? This action cannot be undone.')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
