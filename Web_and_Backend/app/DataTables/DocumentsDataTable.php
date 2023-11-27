<?php

/**
 * Documents DataTable
 *
 * @package     SGTaxi
 * @subpackage  DataTable
 * @category    Documents


 * 
 */

namespace App\DataTables;

use App\Models\Documents;
use Yajra\DataTables\Services\DataTable;
use DB;

class DocumentsDataTable extends DataTable
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
            ->addColumn('document_for', function ($documents) {
                return $documents->document_for;
            })
            ->addColumn('action', function ($documents) {
                $edit = (auth('admin')->user()->can('update_documents')) ? '<a href="'.url('admin/edit_document/'.$documents->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;' : '' ;
                $delete = (auth('admin')->user()->can('delete_documents')) ? '<a data-href="'.url('admin/delete_document/'.$documents->id).'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#confirm-delete"><i class="glyphicon glyphicon-trash"></i></a>' : '';

                return $edit.$delete;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Documents $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Documents $model)
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
            ['data' => 'id' , 'title' => 'Id'],
            ['data' => 'type' , 'title' => 'Documents For'],
            ['data' => 'document_for' , 'title' => 'Country'],
            ['data' => 'document_name' , 'title' => 'Document Name'],
            ['data' => 'status' , 'title' => 'Status'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'documents_' . date('YmdHis');
    }
}
