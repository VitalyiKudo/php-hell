<?php

namespace App\DataTables;

use App\Models\Search;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SearchesDataTable extends DataTable
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
            ->rawColumns(['action', 'user'])
            ->editColumn('user', function ($q) {
                if (empty($q['user']) && empty($q['userId'])) {
                    return null;
                }

                return '<a href="'. route('admin.users.show', $q['userId']) .'"> ' . $q['user'] . '</a>';
            })
            ->addColumn('action', function ($q) {
                return '<a href="'.route('admin.searches.show', $q['id']).'" class="view btn btn-info btn-sm">View</a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Search $collect
     *
     * @return mixed
     */
    public function query(Search $collect)
    {
        return $collect->getSearches();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('searches')
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
            Column::make('key')->title('#'),
            Column::make('id')->title('Search ID'),
            Column::make('user')->title('User'),
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
        return 'Searches_' . date('YmdHis');
    }
}
