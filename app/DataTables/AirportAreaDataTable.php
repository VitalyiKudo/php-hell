<?php

namespace App\DataTables;

use App\Models\AirportArea;
/*
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
*/
use Illuminate\Http\Response;

use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AirportAreaDataTable extends DataTable
{
    /*
     * @param AirportArea $airportArea
     *
     * @return mixed
     *
    public function ajax($query, DataTables $dataTables)
    {
        return $dataTables
            ->collection($query)
            ->make(true);
    }
*/
    /*
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return  \Illuminate\Http\JsonResponse
     */

    public function dataTable($query)
    {
        #dd($query->toJson());
        $res = dataTables()
            ->collection($query)
            ->addColumn('action', 'airport.action')
            ->make(true);
            #->toJson()
            /*->addColumn('action', static function (AirportArea $customer) {
                return "<a href='/customers/detail/{$customer->slug}' class='btn btn-success btn-sm w-100'>Detail</a>";
            })*/
            #);

        #response = $res->toJson();
        #dd($res);
        #return $response;
        return $this->$res;
    }

    /*
     * Get query source of dataTable.
     *
     * @param \App\Models\AirportArea $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    /**
     * @param AirportArea $model
     *
     * @return mixed
     */
    public function query(AirportArea $model)
    {
        #dd(datatables()->of($model)->toJson ());
        #dd($model->getAirportAreas());
        #return $this->applyScopes($model->getAirportAreas());
        return $model->getAirportAreas();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('airportareas-table')
                    ->columns($this->getColumns())
                    #->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
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
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('#'),
            Column::make('Area'),
            Column::make('Count Airport Basic/Additional'),
            Column::make('State'),
            Column::make('Country'),
            Column::make(''),
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
