<?php

namespace App\DataTables;

use App\Models\Airport;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AirportsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return  \Yajra\DataTables\CollectionDataTable|\Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, DataTables $dataTables)
    {
        return $dataTables->collection($query)
            ->rawColumns(['action'])
            ->addColumn('action', function ($q) {
                return '<a href="'.route('admin.airports.edit', $q['id']).'" class="edit btn btn-success btn-sm">Edit</a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Airport $collect
     *
     * @return mixed
     */
    public function query(Airport $collect)
    {
        return $collect->getAirports();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('airports')
            ->addTableClass('table table-bordered table-striped table-hover dataTable dtr-inline')
            ->responsive(true)
            ->columns($this->getColumns())
            ->scrollY('45vh')
            ->scrollCollapse(true)
            ->minifiedAjax()
            ->pageLength(25)
            ->lengthMenu([[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]])
            ->dom('Blfrtip')
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('import'),
                Button::make('print'),
                Button::make('reset'),
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
            Column::make('name')->title('Name'),
            Column::make('city')->title('City'),
            Column::make('iata')->title('IATA'),
            Column::make('createdAt')->title('Created at'),
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
        return 'Airports_' . date('YmdHis');
    }
}
