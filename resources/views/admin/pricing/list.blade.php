@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Pricing</li>
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
            <div class="mb-4 mt-1">
                <input class="form-control" type="text" name="search" id="search" placeholder="Search">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id="fetch-list">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pricing</h5>
                    <h6 class="card-subtitle mb-3 text-muted">The list of airlines</h6>
                    
                    @if ($pricing->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover table-vertical-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="align-middle">#</th>
                                        <th class="align-middle">Departure</th>
                                        <th class="align-middle">Arrival</th>
                                        <th class="align-middle">Price Turbo-prop</th>
                                        <th class="align-middle">Price Light</th>
                                        <th class="align-middle">Price Medium</th>
                                        <th class="align-middle">Price Heavy</th>
                                        <th class="align-middle">Created at</th>
                                        <th class="align-middle"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($pricing as $price)
                                        <tr>
                                            <td class="align-middle">{{ $loop->iteration }}</td>
                                            <td class="align-middle">{{ $price->departure }}</td>
                                            <td class="align-middle">{{ $price->arrival }}</td>
                                            <td class="align-middle">{{ number_format($price->price_turbo, 2, '.', ' ') }} &euro;</td>
                                            <td class="align-middle">{{ number_format($price->price_light, 2, '.', ' ') }} &euro;</td>
                                            <td class="align-middle">{{ number_format($price->price_medium, 2, '.', ' ') }} &euro;</td>
                                            <td class="align-middle">{{ number_format($price->price_heavy, 2, '.', ' ') }} &euro;</td>
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
        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function(){

        function fetch_data(page, query)
        {
            $.ajax({
                url:"/manage/pricings/search?page="+page+"&query="+query,
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
