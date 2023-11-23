<?php

/**
 * Cancel Reason DataTable
 *
 * @package     SGTaxi
 * @subpackage  DataTable
 * @category    Cancel Reason


 * 
 */

namespace App\DataTables;

use App\Models\CancelReason;
use Yajra\DataTables\Services\DataTable;
use DB;
use Auth;

class CancelReasonDataTable extends DataTable
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
            ->addColumn('action', function ($cancel_reason) {
                $edit = '';
                if(Auth::guard('admin')->user()->can('update_manage_reason'))
                    $edit = '<a href="'.url('admin/edit-cancel-reason/'.$cancel_reason->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;';

                return $edit;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param CancelReason $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CancelReason $model)
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
            'reason',
            'cancelled_by',
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
        return 'cancel_reasons_' . date('YmdHis');
    }
}