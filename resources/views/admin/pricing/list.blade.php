@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Airlines</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-3">
                
                
                <form action="{{ route('admin.pricing.import') }}" method="POST" enctype="multipart/form-data" class="form-inline">
                    @csrf
                    <input type="file" name="file" class="form-control mr-3">
                    <button class="btn btn-success" onclick="return confirm('Are you sure that you want to update the database, but the old data will be lost?')">Import Data from Excel</button>
                </form>

                
                <a href="{{ route('admin.pricing.create') }}" class="btn btn-primary">Add new</a>
            </div>
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
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Airlines</h5>
                    <h6 class="card-subtitle mb-3 text-muted">The list of airlines</h6>
                    
                    @if ($pricing->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover table-vertical-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Dep. City</th>
                                        <th>Dep. Airport</th>
                                        <th>Arriv. City</th>
                                        <th>Arriv. Airport</th>
                                        <th>First Price</th>
                                        <th>Second Price</th>
                                        <th>Created at</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($pricing as $price)
                                        <tr>
                                            <td class="align-middle">{{ $loop->iteration }}</td>
                                            
                                            <td class="align-middle">{{ $price->departure_city }}</td>
                                            <td class="align-middle">{{ $price->departure_city_to_airport }}</td>
                                            <td class="align-middle">{{ $price->arrival_city }}</td>
                                            <td class="align-middle">{{ $price->arrival_city_to_airport }}</td>
                                            
                                            <td class="align-middle">{{ number_format($price->price_first, 2, '.', ' ') }} &euro;</td>
                                            <td class="align-middle">{{ number_format($price->price_second, 2, '.', ' ') }} &euro;</td>

                                            <td class="align-middle">{{ $price->created_at->format('d.m.Y H:i') }}</td>
                                            <td class="align-middle text-right">
                                                <a href="{{ route('admin.pricing.edit', $price->id) }}" class="btn btn-secondary btn-sm">
                                                    Edit
                                                </a>
                                                <a href="{{ route('admin.pricing.show', $price->id) }}" class="btn btn-secondary btn-sm">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-primary mb-0">
                            The list of airlines is empty.
                        </div>
                    @endif
                </div>
            </div>

            {{ $pricing->links() }}
        </div>
    </div>
</div>
@endsection
