@extends('admin.layouts.app')

@section('content')
    @csrf
    <div class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">{{__('Fees')}}</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if (session('status'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12" id="fetch-list">
                <div class="card mb-3">
                    <div class="card-body">

                        <h5>{{__('Fees')}}</h5>
                        <h6 class="card-subtitle mb-3 text-muted">{{__('The list of Fees')}}</h6>

                        <div class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">

                                    {!! $dataTable->table() !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}
    <script>
        $(document).ready(function(){
            $('#fees').observe(function () {
                $(this).find('span').tooltip();
            });
        });
    </script>
@endpush

