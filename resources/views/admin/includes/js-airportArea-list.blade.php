<script>
    $(document).ready(function(){

        function fetch_data(page, query)
        {
            $.ajax({
                url:"/manage/airportArea/search?page="+page+"&query="+query,
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

/*
        $("#emptyLegs1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
*/
        //console.log({--!! $airportAreasJson !!--});

        $('#airportAreas').DataTable({
            //"paging": true,
            //"lengthChange": true,
            //"searching": true,
            //"ordering": true,
            //"info": true,
            //"autoWidth": false,
            //"responsive": true,
            //"processing": true,
            "lengthMenu": [5, 10, 25, 50, 75, 100],
            "pageLength": 25,
            "pagingType": "full_numbers",

            /*"dom": 'Qlfrtip',
            "searchBuilder": {
                "depthLimit": 3
            },*/
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": '{{ route('admin.airportArea.ajaxDataList') }}',
                //"url": '',
                "type": "GET",
                //'data': { _token: '{{-- csrf_token() --}}'},
                //"type": "post",
                "dataType": "json",
                //'data': { _token: '{--!! csrf_token() !!--}'},
                //'dataSrc': {--!! $airportAreasJson !!--},

                /*,
                "data": function (searchParams) {
                    searchParams.userName = $("#userName").val();
                    searchParams.sex = $("#sex").val();
                    searchParams.departmentName = $("#departmentName").val();
                    searchParams.orderBy = "user_id ASC";
                    return searchParams;
                }*/
            },
            "columns": [
                { data: 'id', name: '#' },
                { data: 'cityName', name: 'Area' },
                { data: 'cityAirportCount', name: 'Count Airport Basic/Additional' },
                { data: 'regionName', name: 'State' },
                { data: 'countryName', name: 'Country' },
                {
                    data: 'action',
                    name: '',
                    orderable: false,
                    searchable: false
                },
            ]
        });



        $(function(){
            $('[data-toggle="tooltip"]').tooltip({
                placement: 'left'
            });
        });

        function filterByDetailsExtNoAndInput(term) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    if ($(details[dataIndex]).find('.extNo').text() == term) return true;
                    for (var i=0;i<data.length;i++) {
                        if (data[i].toLowerCase().indexOf(term.toLowerCase())>=0) {
                            return true
                        }
                    }
                    return false;
                }
            )
            table.draw();
            $.fn.dataTable.ext.search.pop();
        }

    });

</script>
