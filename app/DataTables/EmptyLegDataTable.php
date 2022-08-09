<?php

namespace App\DataTables;

use Illuminate\Support\Facades\Config;

use App\Models\EmptyLeg;
use App\Traits\EmptyLegStatusTrait;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class EmptyLegDataTable extends DataTable
{
    use EmptyLegStatusTrait;
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return  \Illuminate\Http\JsonResponse
     */

    public function dataTable($query, DataTables $dataTables)
    {
        return $dataTables->collection($query)
            #->editColumn('dateDeparture', '{!! $dateDeparture !!}')
            ->editColumn('dateDeparture', function ($q) {
                return $q['dateDeparture']->format('m/d/Y h:i A');
            })
            ->rawColumns(['active', 'icaoDeparture', 'icaoArrival', 'operatorEmail', 'price', 'action'])
            ->editColumn('active', fn($q) =>'<span class="badge '.$this->statusBg($q["active"]).'">'.$this->status($q["active"]).'</span>')
            ->editColumn('icaoDeparture', fn($q) =>'<span class="cursor-pointer ui-content" data-placement="top" data-toggle="tooltip" data-title="'.$q["airportDeparture"].'" title="'.$q["airportDeparture"].'">'.$q["icaoDeparture"].'</span>')
            ->editColumn('icaoArrival', fn($q) =>'<span class="cursor-pointer ui-content" data-placement="top" data-toggle="tooltip" data-title="'.$q["airportArrival"].' "title="'.$q["airportArrival"].'">'.$q["icaoArrival"].'</span>')
            ->editColumn('operatorEmail', fn($q) =>'<span class="cursor-pointer ui-content" data-placement="top" data-toggle="tooltip" data-title="'.$q["operatorName"].' "title="'.$q["operatorName"].'">'.$q["operatorEmail"].'</span>')
            ->editColumn('price', fn($q) =>'<span class="cursor-pointer ui-content" data-placement="top" data-toggle="tooltip" data-title="'.Config::get('constants.TypePlane.'.$q['typePlane']).'">'.$q["price"].'</span>')
            ->addColumn('action', function ($q) {
                return '<a href="'.route('admin.emptyLegs.show', $q['id']).'" class="view btn btn-info btn-sm">View</a> <a href="'.route('admin.emptyLegs.edit', $q['id']).'" class="edit btn btn-success btn-sm">Edit</a> <a href="'.route('admin.emptyLeg.delete', $q['id']).'" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this airportArea? This action cannot be undone.\')" data-method="delete" data-confirm="Are you sure to delete this inventory?">Delete</a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param EmptyLeg $collect
     *
     * @return mixed
     */
    public function query(EmptyLeg $collect)
    {
        return $collect->getEmptyLegsFull();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('emptyLegs')
            ->addTableClass('table table-bordered table-striped table-hover dataTable dtr-inline')
            ->responsive(true)
            ->columns($this->getColumns())
            ->scrollY('45vh')
            ->scrollCollapse(true)
            ->minifiedAjax()
            ->pageLength(25)
            ->lengthMenu([[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]])
            ->dom('Blfrtip')
            ->orderBy(2, 'desc')
            ->buttons(
                Button::make('create'),
                Button::make('export'),
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
            Column::make('id')->title('#'),
            Column::make('active')->title('Status'),
            Column::make('dateDeparture')->title('Departure Date')->addClass('dt-body-nowrap'),
            Column::make('icaoDeparture')->title('Departure Airport'),
            Column::make('icaoArrival')->title('Arrival Airport'),
            Column::make('operatorEmail')->title('Operator'),
            Column::make('price')->title('Price'),
            Column::make('action')->title('')->orderable(false)->addClass('dt-body-nowrap'),#->width(160),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'EmptyLeg_' . date('YmdHis');
    }
}
