<?php

/**
 * Payments Controller
 *
 * @package     SGTaxi
 * @subpackage  Controller
 * @category    Payments


 * 
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\PaymentsDataTable;

class PaymentsController extends Controller
{
    /**
     * Load Datatable for Rating
     *
     * @param array $dataTable  Instance of PaymentsDataTable
     * @return datatable
     */
    public function index(PaymentsDataTable $dataTable)
    {
        return $dataTable->render('admin.payments.payments');
    }
}