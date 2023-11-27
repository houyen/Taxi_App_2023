<?php

/**
 * Currency DataTable
 *
 * @package     SGTaxi
 * @subpackage  DataTable
 * @category    Currency


 * 
 */

namespace App\DataTables;

use App\Models\Currency;
use Yajra\DataTables\Services\DataTable;
use DB;

class CurrencyDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->of($query)
            ->addColumn('action', function ($currency) {
                $edit = '<a href="'.url('admin/edit_currency/'.$currency->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;';
                $delete = '<a data-href="'.url('admin/delete_currency/'.$currency->id).'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#confirm-delete"><i class="glyphicon glyphicon-trash"></i></a>';

                return $edit.$delete;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Currency $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Currency $model)
    {
        return $model->all();
    }



    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'name',
            'code',
            'rate',
            'status'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'currency_' . date('YmdHis');
    }
}