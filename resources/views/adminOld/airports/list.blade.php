@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Airports</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-3">
                <form action="{{ route('admin.airport.import') }}" method="POST" enctype="multipart/form-data" class="form-inline">
                    @csrf
                    <input type="file" name="file" class="form-control mr-3">
                    <button class="btn btn-success" onclick="return confirm('Are you sure that you want to update the database, but the old data will be lost?')">Import Data from CSV</button>
                </form>
                {{--<a href="{{ route('admin.airports.csvstore') }}" class="btn btn-success" onclick="return confirm('Are you sure that you want to update the database, but the old data will be lost?')">Update database</a>--}}
                <a href="{{ route('admin.airports.create') }}" class="btn btn-primary">Add new</a>
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
            <div class="mb-4 mt-1">
                <input class="form-control" type="text" name="search" id="search" placeholder="Search">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id="fetch-list">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Airports</h5>
                    <h6 class="card-subtitle mb-3 text-muted">The list of airports</h6>
                    
                    @if ($airports->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover table-vertical-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>City</th>
                                        <th>IATA</th>
                                        <th>Created at</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($airports as $airport)
                                        <tr>
                                            <td class="align-middle">{{ $loop->iteration + $airports->firstItem() - 1 }}</td>
                                            <td class="align-middle">{{ $airport->name }}</td>
                                            <td class="align-middle">{{ $airport->city }}</td>
                                            <td class="align-middle">{{ $airport->iata }}</td>
                                            <td class="align-middle">{{ $airport->created_at->format('m-d-Y H:i') }}</td>
                                            <td class="align-middle text-right">
                                                <a href="{{ route('admin.airports.edit', $airport->id) }}" class="btn btn-secondary btn-sm">
                                                    Edit
                                                </a>
                                                <a href="{{ route('admin.airports.show', $airport->id) }}" class="btn btn-secondary btn-sm">
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
                            The list of airports is empty.
                        </div>
                    @endif
                </div>
            </div>
            {{ $airports->links() }}
        </div>
        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function(){

        function fetch_data(page, query)
        {
            $.ajax({
                url:"/manage/airport/search?page="+page+"&query="+query,
                success:function(data)
                {
                    $('#fetch-list').html('');
                    $('#fetch-list').html(data);
                }
            });
        }

        $(document).on('keyup', '#search', function(){
            var query = $('#search').val();
            var page = $('#hidden_page').val();
            fetch_data(page, query);
        });

        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var query = $('#search').val();

            $('li').removeClass('active');
            $(this).parent().addClass('active');
            fetch_data(page, query);
        });

    });
</script>

@endsection