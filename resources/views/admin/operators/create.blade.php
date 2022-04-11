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
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>New operator</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Fill the details of a new operator</h6>

                    <form method="POST" action="{{ route('admin.operators.store') }}" id="quickForm">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}" required placeholder="Enter name">

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail*</label>
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email">

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email_other">E-mail other</label>
                            <input type="email" class="form-control{{ $errors->has('email_other') ? ' is-invalid' : '' }}" id="email_other" name="email_other" value="{{ old('email_other') }}" placeholder="Enter email other">

                            @if ($errors->has('email_other'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email_other') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group" id="city-select2">
                            <label for="city">City*</label>
                            <select name="city[]" multiple id="city" class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}" required>

                            </select>

                            @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- <div class="form-group" id="airport-select2">
                            <label for="airport">Airport*</label>
                            <select name="airport[]" multiple id="airport" class="select2 select2-hidden-accessible form-control{{ $errors->has('airport') ? ' is-invalid' : '' }}" data-placeholder="Select a Airport" aria-hidden="true" tabindex="-1" style="width: 100%;" required>

                            </select>

                            @if ($errors->has('airport'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('airport') }}</strong>
                                </span>
                            @endif
                        </div> --}}

                        <div class="form-group">
                            <label for="web_site">Web-site</label>
                            <input type="url" class="form-control{{ $errors->has('web_site') ? ' is-invalid' : '' }}" id="web_site" name="web_site" value="{{ old('web_site') }}" placeholder="Enter web-site">

                            @if ($errors->has('web_site'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('web_site') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter phone">

                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="tel" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="Enter mobile">

                            @if ($errors->has('mobile'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="fax">Fax</label>
                            <input type="tel" class="form-control{{ $errors->has('fax') ? ' is-invalid' : '' }}" id="fax" name="fax" value="{{ old('fax') }}" placeholder="Enter fax">

                            @if ($errors->has('fax'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fax') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" id="address" name="address" value="{{ old('address') }}" placeholder="Enter address">

                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="hidden" name="active" value="0">
                                <input type="checkbox" class="form-check-input" name="active" value="1" {{ old('active') ? 'checked' : '' }}>
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
</div>

@include('admin.includes.js-operator')

@endsection
