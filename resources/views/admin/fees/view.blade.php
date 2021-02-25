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
                    <li class="breadcrumb-item active" aria-current="page">{{ $fees->item }}</li>
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
                                <dt>Item</dt>
                                <dd>{{ $fees->item }}</dd>

                                <dt>Amount</dt>
                                <dd>{{ $fees->amount }}</dd>

                                <dt>Type</dt>
                                <dd>{{ $fees->type }}</dd>

                                <dt>Active</dt>
                                <dd>{{ old('active', $fees->active) == 1 ? 'True' : 'False' }}</dd>
                                
                            </dl>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
    </div>
</div>
@endsection
