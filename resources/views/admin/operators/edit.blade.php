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
                    <h5>{{ $operator->name }}</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Edit operator</h6>

                    <form method="POST" action="{{ route('admin.operators.update', $operator->id) }}" id="quickForm">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ old('name', $operator->name) }}" required>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail*</label>
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email', $operator->email) }}" disabled>
                            <input type="hidden" name="email_actual" value="{{ old('email', $operator->email) }}">

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email_other_other">E-mail other</label>
                            <input type="email" class="form-control{{ $errors->has('email_other') ? ' is-invalid' : '' }}" id="email_other" name="email_other" value="{{ old('email_other', $operator->email_other) }}">

                            @if ($errors->has('email_other'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email_other') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group" id="city-select2">
                            <label for="city">City*</label>
                            <select name="city[]" multiple id="city" class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}" required>
                                @forelse ($cities as $city)
                                    <option value={{ $city['geonameid'] }} selected>{{ $city['city'] }}{{ ($city['region']) ? ', '.$city['region'] : '' }}{{ ($city['country']) ? ', '.$city['country'] : '' }}</option>
                                @empty
                                    <option value="">Select a City</option>
                                @endforelse
                            </select>
                            <input type="hidden" name="city_old" value="{{ old('cities', $cities) }}">
                            @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="web_site">Web-site</label>
                            <input type="url" class="form-control{{ $errors->has('web_site') ? ' is-invalid' : '' }}" id="web_site" name="web_site" value="{{ old('web_site', $operator->web_site) }}">

                            @if ($errors->has('web_site'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('web_site') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone', $operator->phone) }}">

                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="tel" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" id="mobile" name="mobile" value="{{ old('mobile', $operator->mobile) }}">

                            @if ($errors->has('mobile'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="fax">Fax</label>
                            <input type="tel" class="form-control{{ $errors->has('fax') ? ' is-invalid' : '' }}" id="fax" name="fax" value="{{ old('fax', $operator->fax) }}">

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

                        <div class="form-group">
                            <div class="form-check">
                                <input type="hidden" name="active" value="0">
                                <input type="checkbox" class="form-check-input" name="active" value="1" {{ ($operator->active === 1) ? 'checked' : '' }}>
                                <label for="active">{{__('Active')}}</label>
                            </div>

                            @if ($errors->has('active'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('active') }}</strong>
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
                    <h5>Delete operator</h5>

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

@include('admin.includes.js-operator')

@endsection
