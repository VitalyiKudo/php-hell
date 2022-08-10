@extends('admin.layouts.app')

@section('content')
    @csrf
    <div class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">{{__('Users')}}</li>
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

                        <h5>{{__('Users')}}</h5>
                        <h6 class="card-subtitle mb-3 text-muted">{{__('The list of Users')}}</h6>

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
            $('#users').observe(function () {
                $(this).find('span').tooltip(); // .addClass('form-control')
            });
        });
    </script>
@endpush

