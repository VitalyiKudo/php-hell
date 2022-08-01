<?php

namespace App\DataTables;

use App\Models\Order;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
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
            ->rawColumns(['action', 'user', 'price', 'orderStatus'])
            ->editColumn('user', function ($q) {
                if (empty($q['user']) && empty($q['userId'])) {
                    return null;
                }

                return '<a href="'. route('admin.users.show', $q['userId']) .'"> ' . $q['user'] . '</a>';
            })
            ->editColumn('orderStatus', function ($q) {
                $column = '';

                if (is_null($q['isAccepted'])) {
                    $column .= '<span class="badge badge-pill badge-warning">Awaiting for Acceptance</span>';
                } elseif ($q['isAccepted'] == 1) {
                    $column .= '<span class="badge badge-pill badge-success">Accepted</span> ';
                    $column .= '<span class="badge badge-pill badge-'. $q['orderStatusStyle'] .'"> ' . $q['orderStatus'] . '</span>';
                } else {
                    $column .= '<span class="badge badge-pill badge-danger">Declined</span>';
                }

                return $column;
            })
            ->editColumn('price', function ($q) {
                return '<span class="cursor-pointer" data-toggle="tooltip" data-title="'.$q["price"].'">' .
                    number_format($q['price'], 2, '.', ' ') . ' &dollar; </span>';
            })
            ->addColumn('action', function ($q) {
                return '<a href="'.route('admin.orders.show', $q['id']).'" class="view btn btn-info btn-sm">View</a> <a href="'.route('admin.orders.edit', $q['id']).'" class="edit btn btn-success btn-sm">Edit</a>';
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
            ->buttons(
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
            Column::make('id')->title('Order ID'),
            Column::make('user')->title('User'),
            Column::make('orderStatus')->title('Status'),
            Column::make('price')->title('Price'),
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
        return 'Orders_' . date('YmdHis');
    }
}
