<?php

namespace App\DataTables;

use Illuminate\Support\Facades\Config;

use App\Models\Order;

use App\Traits\EmptyLegStatusTrait;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class OrderDataTable extends DataTable
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
            ->editColumn('created', function ($q) {
                return $q['created']->format('Y-m-d');
            })

            ->rawColumns(['id', 'user', 'status', 'price', 'created', 'action'])
            ->editColumn('status', fn($q) =>'<span class="badge '.$this->statusBg($q["statusBg"]).'">'.$q["status"].'</span>')
/*            ->editColumn('icaoDeparture', fn($q) =>'<span class="cursor-pointer" data-toggle="tooltip" data-title="'.$q["airportDeparture"].'">'.$q["icaoDeparture"].'</span>')
            ->editColumn('icaoArrival', fn($q) =>'<span class="cursor-pointer" data-toggle="tooltip" data-title="'.$q["airportArrival"].'">'.$q["icaoArrival"].'</span>')
            ->editColumn('operatorEmail', fn($q) =>'<span class="cursor-pointer" data-toggle="tooltip" data-title="'.$q["operatorName"].'">'.$q["operatorEmail"].'</span>')
            ->editColumn('price', fn($q) =>'<span class="cursor-pointer" data-toggle="tooltip" data-title="'.Config::get('constants.TypePlane.'.$q['typePlane']).'">'.$q["price"].'</span>')
            */
            ->addColumn('action', function ($q) {
                return '<a href="'.route('admin.orders.show', $q['id']).'" class="view btn btn-info btn-sm">View</a> <a href="'.route('admin.orders.edit', $q['id']).'" class="edit btn btn-success btn-sm">Edit</a> <a href="'.route('admin.orders.delete', $q['id']).'" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this Order? This action cannot be undone.\')" data-method="delete" data-confirm="Are you sure to delete this inventory?">Delete</a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Order $collect
     *
     * @return mixed
     */
    public function query(Order $collect)
    {
        return $collect->getOrders();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('orders')
            ->addTableClass('table table-bordered table-striped table-hover dataTable dtr-inline')
            ->responsive(true)
            ->columns($this->getColumns())
            ->scrollY('45vh')
            ->scrollCollapse(true)
            ->minifiedAjax()
            ->pageLength(25)
            ->lengthMenu([[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]])
            ->dom('Blfrtip')
            ->orderBy(1, 'desc')
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
            Column::make('key')->title('#'),
            Column::make('id')->title('Order ID'),
            Column::make('user')->title('User'),
            Column::make('status')->title('Status'),
            Column::make('price')->title('Price'),
            Column::make('created')->title('Created at'),
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
        return 'Orders_' . date('YmdHis');
    }
}
