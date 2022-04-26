<?php

namespace App\DataTables;

use App\Models\AirportArea;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\DataTables;

class AirportAreaDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return  \Illuminate\Http\JsonResponse
     */

    public function dataTable($query, DataTables $dataTables)
    {
        return $dataTables->collection($query)
            ->addColumn('action', function ($q) {
            return '<a href="'.route('admin.airportAreas.show', $q['geoNameIdCity']).'" class="view btn btn-info btn-sm">View</a> <a href="'.route('admin.airportAreas.edit', $q['geoNameIdCity']).'" class="edit btn btn-success btn-sm">Edit</a> <a href="'.route('admin.airportArea.delete', $q['geoNameIdCity']).'" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this airportArea? This action cannot be undone.\')" data-method="delete" data-confirm="Are you sure to delete this inventory?">Delete</a>';
        });
            /*->rawColumns(['cityName', 'action'])
            ->editColumn('cityName', function($q) {
                return '<span class="cursor-pointer" data-toggle="tooltip" data-title="' . $q['regionName'] . '">Hi ' . $q['geoNameIdCity'] . '!</span>';
            });*/
    }

    /**
     * Get query source of dataTable.
     *
     * @param AirportArea $collect
     *
     * @return mixed
     */
    public function query(AirportArea $collect)
    {
        return $collect->getAirportAreas();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('airportAreas')
            ->addTableClass('table table-bordered table-striped table-hover dataTable dtr-inline')
            ->responsive(true)
            ->columns($this->getColumns())
            ->scrollY('45vh')
            ->scrollCollapse(true)
            #->info(true)
            #->language( "//cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json" )
            ->minifiedAjax()
            ->pageLength(25)
            ->lengthMenu([[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]])
            ->dom('Blfrtip')
            #->orderBy(1, 'asc')
            /*->parameters([
                             'drawCallback' => 'function() { alert("Table Draw Callback") }',
                         ])*/
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                #Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('key')->title('#'),
            Column::make('cityName')->title('Area'),
            Column::make('cityAirportCount')->title('Main'),
            Column::make('areaAirportCount')->title('Satellite'),
            Column::make('regionName')->title('State'),
            Column::make('countryName')->title('Country'),
            Column::make('action')->title('')->orderable(false),
            ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'AirportArea_' . date('YmdHis');
    }
}
