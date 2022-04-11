<?php
namespace App\TableModels;

use SingleQuote\DataTables\Controllers\ColumnBuilder;
use SingleQuote\DataTables\Fields\Button; //button field

/**
 * TableModel for SingleQuote\DataTable
 * See the full focs here for the table models https://singlequote.github.io/Laravel-datatables/table-models
 *
 */
class AirportAreasTable extends ColumnBuilder
{

    // @var array
    /**
     * @var string
     */
    public $tableClass = "table table-bordered table-striped table-hover dataTable dtr-inline";

    /**
     * Remember the data page of the user
     *
     * @var bool
     */
    public $rememberPage = true;


    /**
     * Set the columns for your table
     * These are also your header, searchable and filter columns
     *
     * @var array
     */
    public $columns = [
        'name',
        'Area',
        [
            "data"          => "id",
            "name"          => "Test",
            "orderable"     => true,
            "searchable"    => true

            /*
            'data' => $this->toLower($data),
            'name' => $this->toLower($name),
            'original' => $original,
            'searchable' => $searchable,
            'orderable' => $orderable ?? true,
            'class' => $class,
            'columnSearch' => $columnSearch
            */
        ]
    ];


   /**
    * Set the translation columns for the headers
    *
    * @return array
    */
    public function translate() : array
    {
        return [
            'name' => __('Name'),
        ];
    }


   /**
    * Run an elequent query
    *
    * @param \Illuminate\Database\Query\Builder $query
    * @return \Illuminate\Database\Query\Builder
    */
    public function query($query)
    {
        return $query->whereNotNull('id');
    }


    /**
     * Alter the fields displayed by the resource.
     *
     * @return array
     */
    public function fields() : array
    {
        return [
            Button::make('id')->class('my-button-class')->route('admin.airportAreas.show', 'id'),
            Button::make('id')->class('my-button-class')->route('admin.airportAreas.edit', 'id'),
            Button::make('id')->class('my-button-class')->method('delete')->route('admin.airportAreas.destroy', 'id'),
        ];
    }

}
