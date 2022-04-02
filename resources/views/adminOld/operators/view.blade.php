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
                    <li class="breadcrumb-item active" aria-current="page">{{ $operator->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>View Airline</h3>

                    <div class="card">
                        <div class="card-body">

                            <dl class="mb-0">
                                <dt>Name</dt>
                                <dd>{{ $operator->name }}</dd>

                                <dt>Web-site</dt>
                                <dd>{{ $operator->web_site }}</dd>

                                <dt>E-mail</dt>
                                <dd>{{ $operator->email }}</dd>

                                <dt>Phone</dt>
                                <dd>{{ $operator->phone }}</dd>

                                <dt>Mobile</dt>
                                <dd>{{ $operator->mobile }}</dd>

                                <dt>Fax</dt>
                                <dd>{{ $operator->fax }}</dd>

                                <dt>Address</dt>
                                <dd class="mb-0">
                                    {{ $operator->address }}
                                </dd>
                            </dl>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
    </div>
</div>
@endsection
