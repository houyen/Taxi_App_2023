<?php

/**
 * Trips Controller
 *
 * @package     SGTaxi
 * @subpackage  Controller
 * @category    Trips


 * 
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Start\Helpers;
use App\Models\User;
use App\Models\Trips;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Models\SiteSettings;
use App\Models\Currency;
use App\Models\PayoutCredentials;
use App\Models\DriverOweAmount;
use App\DataTables\CancelTripsDataTable;
use App\DataTables\TripsDataTable;
use Excel;
use DB;
use Auth;

class TripsController extends Controller
{
    /**
     * Load Datatable for Trips
     *
     * @return view file
     */
    public function index(TripsDataTable $dataTable)
    {
        return $dataTable->render('admin.trips.index');
    }
    
    /**
     * Load particular trip data 
     *
     * @return view file
     */
    public function view(Request $request)
    {
        $data['result'] = Trips::
                where('id',$request->id)
                ->where(function($query)  {
                    if(LOGIN_USER_TYPE=='company') {
                        $query->whereHas('driver',function($q1){
                            $q1->where('company_id',Auth::guard('company')->user()->id);
                        });
                    }
                })
                ->first();

        if($data['result']) {
            $data['back_url'] = url(LOGIN_USER_TYPE.'/trips');
            if($request->s == 'overall') {
                $data['back_url'] = url(LOGIN_USER_TYPE.'/statements/overall');
            }
            elseif($request->s == 'driver') {
                $data['back_url'] = url(LOGIN_USER_TYPE.'/view_driver_statement/'.$data['result']->driver_id);
            }


            $driver_owe_amount = DriverOweAmount::where('user_id',$data['result']->driver_id)->first();

            return view('admin.trips.view', $data);
        }
        flashMessage('danger', 'Invalid ID');
        return redirect(LOGIN_USER_TYPE.'/trips');          
    }

    /**
     * Export trip data to excel 
     *
     * @return view file
     */
    public function export(Request $request)
    {
      

           $from = date('Y-m-d H:i:s', strtotime($request->from));
            $to = date('Y-m-d H:i:s', strtotime($request->to));
            $category = $request->category;

           
                $result = Trips::where('trips.created_at', '>=', $from)->where('trips.created_at', '<=', $to) 
                        ->join('users', function($join) {
                                $join->on('users.id', '=', 'trips.user_id');
                            })
                        ->join('currency', function($join) {
                                $join->on('currency.code', '=', 'trips.currency_code');
                            })
                        ->join('car_type', function($join) {
                                $join->on('car_type.id', '=', 'trips.car_id');
                            })
                        ->leftJoin('users as u', function($join) {
                                $join->on('u.id', '=', 'trips.driver_id');
                            })
                        ->select(['trips.id as id','trips.begin_trip as begin_trip','trips.pickup_location as pickup_location','trips.drop_location as drop_location', 'u.first_name as driver_name', 'users.first_name as rider_name',  DB::raw('CONCAT(currency.symbol, trips.total_fare) AS total_amount'), 'trips.status','car_type.car_name as car_name', 'trips.created_at as created_at', 'trips.updated_at as updated_at', 'trips.*'])->get();
        

        Excel::create('Trips-report', function($excel) use($result) {
            $excel->sheet('sheet1', function($sheet) use($result) {

                 $data[0]=['Id','From Location','To Location','Date','Driver Name','Rider Name','Fare','Vehicle Details','Status','Created At'];

                foreach ($result as $key => $value) {
                    $data[]=array($value->id,$value->pickup_location,$value->drop_location,date('d-m-y h:m a',strtotime($value->date)),$value->rider_name,$value->driver_name, html_entity_decode($value->total_amount),$value->car_name,$value->status,$value->created_at);
                }
                $data = array_values($data);
                 $sheet->with($data);
            });
        })->export('csv');
    }

    /**
     * Load Datatable for Cancel trips
     *
     * @param array $dataTable  Instance of Cancel tripsDataTable
     * @return datatable
     */
    public function cancel_trips(CancelTripsDataTable $dataTable)
    {
        return $dataTable->render('admin.trips.cancel');
    }

}