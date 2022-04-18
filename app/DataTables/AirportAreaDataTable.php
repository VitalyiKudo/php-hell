<?php

namespace App\DataTables;

use App\Models\AirportArea;

use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
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
        return $dataTables->collection($query)->addColumn('action', function ($q) {
            return '<a href="'.route('admin.airportAreas.show', $q['geoNameIdCity']).'" class="view btn btn-info btn-sm">View</a> <a href="'.route('admin.airportAreas.edit', $q['geoNameIdCity']).'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
        });
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
            #->language( "//cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json" )
            ->minifiedAjax()
            ->pageLength(25)
            ->dom('Bfrtip')
            ->orderBy(0, 'asc')
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
            Column::make('cityAirportCount')->title('Count Basic'),
            Column::make('areaAirportCount')->title('Count Additional'),
            Column::make('regionName')->title('State'),
            Column::make('countryName')->title('Country'),
            Column::make('action')->title(''),
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
