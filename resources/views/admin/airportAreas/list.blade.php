@extends('admin.layouts.app')

@section('content')
    @csrf
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">AirportAreas</li>
                </ol>
            </nav>
        </div>
    </div>

    <!--div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-3">
                <form action="{{-- route('admin.emptyLeg.import') }}" method="POST" enctype="multipart/form-data" class="form-inline">
                    @csrf
                    <input type="file" name="file" class="form-control mr-3">
                    <button class="btn btn-success" onclick="return confirm('Are you sure that you want to update the database, but the old data will be lost?')">Import Data from Excel</button>
                </form>
                <a href="{{ route('admin.airportAreas.create') --}}" class="btn btn-primary">Add new</a>
            </div>
        </div>
    </div -->

    @if (session('status'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    <!-- div class="row">
        <div class="col-md-12">
            <div class="mb-4 mt-1">
                <input class="form-control" type="text" name="search" id="search" placeholder="Search">
            </div>
        </div>
    </div -->

    <div class="row">
        <div class="col-md-12" id="fetch-list">
            <div class="card mb-3">
                <div class="card-body">

                    <a href="{{ route('admin.airportAreas.create') }}" class="btn btn-primary float-right">Add new</a>
                    <h5>AirportAreas</h5>
                    <h6 class="card-subtitle mb-3 text-muted">The list of AirportAreas</h6>

                    @if ($airportAreas->isNotEmpty())
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="airportAreas" class="table table-bordered table-striped table-hover dataTable dtr-inline">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Area</th>
                                            <th>Count Airport</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($airportAreas as $key => $airportArea)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $airportArea['cityName'] }}</td>
                                                <td></td>
                                                <td>{{ $airportArea['regionName'] }}</td>
                                                <td>{{ $airportArea['countryName'] }}</td>
                                                <td class="text-right">
                                                    <a href="{{ route('admin.airportAreas.edit', $airportArea['id']) }}" class="btn btn-secondary btn-sm">
                                                        Edit
                                                    </a>
                                                    <a href="{{ route('admin.airportAreas.show', $airportArea['id']) }}" class="btn btn-secondary btn-sm">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="alert alert-primary mb-0">
                            The list of airportAreas is empty.
                        </div>
                    @endif
                </div>
            </div>

            {{ $airportAreas->links() }}
        </div>
        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    </div>
</div>

@include('admin.includes.js-airportArea')

@endsection
