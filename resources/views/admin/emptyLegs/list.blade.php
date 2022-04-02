@extends('admin.layouts.app')

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">EmptyLegs</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-3">
                <form action="{{ route('admin.emptyLeg.import') }}" method="POST" enctype="multipart/form-data" class="form-inline">
                    @csrf
                    <input type="file" name="file" class="form-control mr-3">
                    <button class="btn btn-success" onclick="return confirm('Are you sure that you want to update the database, but the old data will be lost?')">Import Data from Excel</button>
                </form>
                <a href="{{ route('admin.emptyLegs.create') }}" class="btn btn-primary">Add new</a>
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
                    <h5>EmptyLegs</h5>
                    <h6 class="card-subtitle mb-3 text-muted">The list of EmptyLegs</h6>

                    @if ($emptyLegs->isNotEmpty())
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="emptyLegs" class="table table-bordered table-striped table-hover dataTable dtr-inline">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Status</th>
                                            <th>Departure Date</th>
                                            <th>Departure Airport</th>
                                            <th>Arrival Airport</th>
                                            <th>Operator</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($emptyLegs as $emptyLeg)
                                            <tr>
                                                <td>{{ $emptyLeg['id'] }}</td>
                                                <td><span class="badge{{ $emptyLeg['active'] === 1 ? ' bg-danger' :  ' bg-success' }}">{{ $emptyLeg['active'] === 1 ? 'Active' :  'Done' }}</span></td>
                                                <td>{{ $emptyLeg['dateDeparture']->format('m-d-Y') }}</td>
                                                <td>{{ $emptyLeg['icaoDeparture'] }}</td>
                                                <td>{{ $emptyLeg['icaoArrival'] }}</td>
                                                <td>{{ $emptyLeg['operatorEmail'] }}</td>
                                                <td>{{ $emptyLeg['price'] }}</td>
                                                <td class="text-right">
                                                    <a href="{{ route('admin.emptyLegs.edit', $emptyLeg['id']) }}" class="btn btn-secondary btn-sm">
                                                        Edit
                                                    </a>
                                                    <a href="{{ route('admin.emptyLegs.show', $emptyLeg['id']) }}" class="btn btn-secondary btn-sm">
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
                            The list of emptyLegs is empty.
                        </div>
                    @endif
                </div>
            </div>

            {{ $emptyLegs->links() }}
        </div>
        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function(){

        function fetch_data(page, query)
        {
            $.ajax({
                url:"/manage/emptyLeg/search?page="+page+"&query="+query,
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

        /*$(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var query = $('#search').val();

            $('li').removeClass('active');
            $(this).parent().addClass('active');
            fetch_data(page, query);
        });*/


            $("#emptyLegs1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#emptyLegs').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });



    });
</script>

@endsection
