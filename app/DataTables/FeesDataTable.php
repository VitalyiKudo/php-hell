<?php

namespace App\DataTables;

use App\Models\Fees;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FeesDataTable extends DataTable
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
            ->rawColumns(['action', 'active', 'sall'])
            ->addColumn('action', function ($q) {
                return '<a href="'.route('admin.fees.show', $q['id']).'" class="view btn btn-info btn-sm">View</a> <a href="'.route('admin.fees.edit', $q['id']).'" class="edit btn btn-success btn-sm">Edit</a>';
            })
            ->editColumn('active', function ($q) {
                $isActive = $q['active'] ? 'text-success' : 'text-danger';
                $isActiveText = $q['active'] ? 'Yes' : 'No';

                return '<span class="cursor-pointer '. $isActive .'" data-toggle="tooltip">' . $isActiveText . '</span>';
            })
            ->editColumn('sall', function ($q) {
                $isSall = $q['sall'] === Fees::IS_SALL ? 'text-success' : 'text-danger';
                $isSallText = $q['sall'] === Fees::IS_SALL ? 'Yes' : 'No';

                return '<span class="cursor-pointer '. $isSall .'" data-toggle="tooltip">' . $isSallText . '</span>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Fees $collect
     *
     * @return mixed
     */
    public function query(Fees $collect)
    {
        return $collect->getFees();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('fees')
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
            Column::make('item')->title('Item'),
            Column::make('amount')->title('Amount'),
            Column::make('type')->title('Type'),
            Column::make('active')->title('Active'),
            Column::make('sall')->title('Discount'),
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
        return 'Fees_' . date('YmdHis');
    }
}
