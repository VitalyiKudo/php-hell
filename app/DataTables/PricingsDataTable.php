<?php

namespace App\DataTables;

use App\Models\Pricing;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PricingsDataTable extends DataTable
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
            ->rawColumns(['action', 'price_turbo', 'price_light', 'price_medium', 'price_heavy'])
            ->editColumn('price_turbo', function ($q) {
                return '<span class="cursor-pointer" data-toggle="tooltip" data-title="'.$q["price_turbo"].'">' .
                    number_format($q['price_turbo'], 2, '.', ' ') . ' &dollar; </span>';
            })
            ->editColumn('price_light', function ($q) {
                return '<span class="cursor-pointer" data-toggle="tooltip" data-title="'.$q["price_light"].'">' .
                    number_format($q['price_light'], 2, '.', ' ') . ' &dollar; </span>';
            })
            ->editColumn('price_medium', function ($q) {
                return '<span class="cursor-pointer" data-toggle="tooltip" data-title="'.$q["price_medium"].'">' .
                    number_format($q['price_medium'], 2, '.', ' ') . ' &dollar; </span>';
            })
            ->editColumn('price_heavy', function ($q) {
                return '<span class="cursor-pointer" data-toggle="tooltip" data-title="'.$q["price_heavy"].'">' .
                    number_format($q['price_heavy'], 2, '.', ' ') . ' &dollar; </span>';
            })
            ->addColumn('action', function ($q) {
                return '<a href="'.route('admin.pricing.show', $q['id']).'" class="view btn btn-info btn-sm">View</a> <a href="'.route('admin.pricing.edit', $q['id']).'" class="edit btn btn-success btn-sm">Edit</a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Pricing $collect
     *
     * @return mixed
     */
    public function query(Pricing $collect)
    {
        return $collect->getPricing();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('pricings')
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
            Column::make('departure')->title('Departure'),
            Column::make('arrival')->title('Arrival'),
            Column::make('price_turbo')->title('Price Turbo-prop'),
            Column::make('price_light')->title('Price Light'),
            Column::make('price_medium')->title('Price Medium'),
            Column::make('price_heavy')->title('Price Heavy'),
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
        return 'Pricings_' . date('YmdHis');
    }
}
