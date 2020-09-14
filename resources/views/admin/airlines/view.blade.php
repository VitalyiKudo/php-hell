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
                    <li class="breadcrumb-item active" aria-current="page">{{ $airline->type }}</li>
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
                                <dt>Type</dt>
                                <dd>{{ $airline->type }}</dd>

                                <dt>Reg. number</dt>
                                <dd>{{ $airline->reg_number }}</dd>

                                <dt>Category</dt>
                                <dd>{{ $airline->category }}</dd>

                                <dt>Homebase</dt>
                                <dd>{{ $airline->homebase }}</dd>

                                <dt>Max PAX</dt>
                                <dd>{{ $airline->max_pax }}</dd>

                                <dt>YOM</dt>
                                <dd>{{ $airline->yom }}</dd>

                                <dt>Operator</dt>
                                <dd class="mb-0">
                                    {{ $airline->operator }}
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
