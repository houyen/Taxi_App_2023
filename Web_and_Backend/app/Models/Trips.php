<?php

/**
 * Trips Model

 * @subpackage  Model
 * @category    Trips

 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DB;
use Auth;

class Trips extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trips';

    protected $appends = ['vehicle_name','driver_name','rider_name','rider_profile_picture','driver_thumb_image','rider_thumb_image','date','pickup_time','pickup_time_formatted','drop_time','pickup_date_time','trip_time','begin_date','date_time_trip','driver_joined_at','commission','map_image','currency_symbol','status','toll_fee_reason'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fare_estimation' => 'array',
    ];

    public static $withoutAppends = false;


    // Join with profile_picture table
    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
      // Join with Pool Trip table
    public function trips() {
        return $this->hasMany('App\Models\Trips','pool_id','id');
    }
    
    // Join with user table
    public function driver()
    {
        return $this->belongsTo('App\Models\User','driver_id','id');
    }
    // Join with cancel table
    public function cancel()
    {
        return $this->belongsTo('App\Models\Cancel','id','trip_id');
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language','language_code','value');
    } 
    // Join with profile_picture table
    public function profile_picture()
    {
        return $this->belongsTo('App\Models\ProfilePicture','user_id','user_id');
    }

    // Join with car_type table
    public function car_type()
    {
        return $this->belongsTo('App\Models\CarType','car_id','id');
    }

    // Join with driver_location table
    public function driver_location()
    {
        return $this->belongsTo('App\Models\DriverLocation','driver_id','user_id');
    }
    // Join with rating table
    public function rating()
    {
        return $this->belongsTo('App\Models\Rating','user_id','user_id');
    }
     public function trip_rating()
    {
        return $this->belongsTo('App\Models\Rating','id','trip_id');
    }

    // Join with request table
    public function ride_request()
    {
        return $this->belongsTo('App\Models\Request','request_id','id');
    }
    
    // Join with Driver Address table
    public function driver_address()
    {
        return $this->belongsTo('App\Models\DriverAddress','driver_id','user_id');
    }

    // Get vehicle name
    public function getVehicleNameAttribute()
    {
        return CarType::find($this->attributes['car_id'])->car_name;
    } 

     // Get status
    public function getStatusAttribute()
    {
        $status = $this->attributes['status'];
        if(LOGIN_USER_TYPE == 'company' || LOGIN_USER_TYPE == 'admin' || $status == "Completed") {
            return $status;
        }

        return $status;
    }

    public function getCommissionAttribute()
    {
        return $this->attributes['access_fee'] + ( $this->attributes['peak_amount'] - $this->attributes['driver_peak_amount'] ) + $this->attributes['schedule_fare'] + $this->attributes['driver_or_company_commission'];
    }
    
    public function total_fare()
    {
        return $total_fare = $this->attributes['base_fare'] + $this->attributes['time_fare'] + $this->attributes['distance_fare'] + $this->attributes['schedule_fare'] + $this->attributes['access_fee'] + $this->attributes['peak_amount'] + $this->attributes['tips'] + $this->attributes['waiting_charge'] + $this->attributes['toll_fee'];
    }
   
    // get begin trip value
    public function getDateAttribute()
    {
        return strtotime($this->attributes['begin_trip']);
    }

    public function getMapImageAttribute()
    {   
        $map_image = @$this->attributes['map_image'];       
        $id = array_key_exists('id', $this->attributes) ? $this->attributes['id']:$this->attributes['trip_id'];
        if($map_image != '') {
            $map_image = url('images/map/'.$id.'/'.$map_image);
        }
        return $map_image;
    }

    public function getTripImageAttribute()
    {   
        $map_image = @$this->attributes['map_image'];

        if($map_image != '') {
            return url('images/map/'.$this->attributes['id'].'/'.$map_image);
        }

        $google_service = resolve("google_service");
        return $google_service->GetStaticMap($this->attributes['pickup_latitude'], $this->attributes['pickup_longitude'], $this->attributes['drop_latitude'], $this->attributes['drop_longitude'],$this->attributes['trip_path']);
    }

    // get trip currency code
    public function getCurrencySymbolAttribute()
    {
        if(array_key_exists('id', $this->attributes)) {
            $trips = Trips::where('request_id',$this->attributes['id']);
            if($trips->count()) {
                $code =  @$trips->value('currency_code');
                return Currency::where('code',$code)->value('symbol');
            } else {
                return "$";
            }
        }

        return html_entity_decode($this->attributes['currency_symbol']);
    }

    // get begin trip value with the format: yyyy-mm-dd
    public function getBeginDateAttribute()
    {
        return date('Y-m-d',strtotime($this->attributes['created_at']));
    }
    // get pickup date with the format: Thursday, July 20, 2017 11:58 AM
    public function getPickupDateTimeAttribute()
    {
      return date('l, F d, Y h:i A',strtotime($this->attributes['created_at']));
    }
    // get pickup time with the format: 11:58 AM
    public function getPickupTimeAttribute()
    {
      return date('h:i A',strtotime($this->attributes['begin_trip']));
    }

    // get pickup time with the format: 11:58 AM
    public function getPickupTimeFormattedAttribute()
    {
        $begin_trip = $this->getFormattedTime('begin_trip');
        if($begin_trip == '-') {
            return '';
        }
        return $begin_trip;
    }
    // get drop time with the format: 11:58 AM
    public function getDropTimeAttribute()
    {
      return date('h:i A',strtotime($this->attributes['end_trip']));
    }
    // get Driver name
    public function getDriverNameAttribute()
    {
      return User::find($this->attributes['driver_id'])->first_name;
    }
    // get Rider name
    public function getRiderNameAttribute()
    {
      return User::find($this->attributes['user_id'])->first_name;
    }
    // get Rider Profile Picture
    public function getRiderProfilePictureAttribute()
    {
      $profile_picture=ProfilePicture::where('user_id',$this->attributes['user_id'])->first();
      return isset($profile_picture)?$profile_picture->src:url('images/user.jpeg');
    }
    // get DriverThumb image
    public function getDriverThumbImageAttribute()
    {
      $profile_picture=ProfilePicture::find($this->attributes['driver_id']);
      return isset($profile_picture)?$profile_picture->src:url('images/user.jpeg');
    }
    // get DriverThumb image
    public function getRiderThumbImageAttribute()
    {
      $profile_picture=ProfilePicture::find($this->attributes['user_id']);
      return isset($profile_picture)?$profile_picture->src:url('images/user.jpeg');
    }
    // get total trip time
    public function getTripTimeAttribute()
    {      
      $begin_time = new DateTime($this->attributes['begin_trip']);
      $end_time   = new DateTime($this->attributes['end_trip']);
      $timeDiff   = date_diff($begin_time,$end_time);
      return $timeDiff->format('%H').':'.$timeDiff->format('%I').':'.$timeDiff->format('%S');
               
    }

    /**
     * get Total Trip Fare Attribute
     * 
     */
    public function getTotalTripFareAttribute()
    {
        return number_format(($this->attributes['total_fare']-$this->attributes['access_fee']),2, '.', '');    
    }

    /**
     * get Total Fare Attribute
     * 
     */
    public function getTotalFareAttribute()
    {
        return number_format(($this->attributes['total_fare']),2, '.', ''); 
    }


    /**
     * get Access Fee Attribute
     * 
     */
    public function getAccessFeeAttribute()
    {
        return number_format(($this->attributes['access_fee']),2, '.', ''); 
    }


    /**
     * get Date Time Trip Attribute
     * 
     */
    public function getDateTimeTripAttribute()
    {
        $full = false;

        $now = new DateTime;
        $ago = new DateTime($this->attributes['created_at']);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => __('messages.date_time.year'),
            'm' => __('messages.date_time.month'),
            'w' => __('messages.date_time.week'),
            'd' => __('messages.date_time.day'),
            'h' => __('messages.date_time.hour'),
            'i' => __('messages.date_time.minute'),
            's' => __('messages.date_time.second'),
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            }
            else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        if($string) {
            return implode(', ', $string) . ' '.__('messages.ago');
        }
        return __('messages.just_now');
    }

     /**
     * Get driver Joined date
     * 
     */
    public function getDriverJoinedAtAttribute()
    {
        $full = false;
        $driver_created_at=DB::table('users')->where('id',$this->attributes['driver_id'])->get()->first()->created_at;
        $now = new DateTime;
        $ago = new DateTime($driver_created_at);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    // get Formatted Time with the format: 11:58 AM
    public function getFormattedTime($attribute)
    {
        $formatted_time = '-';
        $trip_time = strtotime($this->attributes[$attribute]);
        if($trip_time > 0) {
            $formatted_time = date('g:i A',$trip_time);
        }

        return $formatted_time;
    }

     /**
     * Get Peak subtotal
     * 
     */
    public function getPeakSubtotalFareAttribute()
    {
        return $this->peak_amount + $this->subtotal_fare;
    }

     /**
     * Get week days
     * 
     */
    public function getWeekDaysAttribute()
    {
        $week_no = 0;
        $year = date('Y', strtotime($this->attributes['created_at']));
        $week_no = date('W', strtotime($this->attributes['created_at']));
        $week_days = \App\Http\Start\Helpers::getWeekDates($year, $week_no);

        return $week_days;
    }

     /**
     * Scope to get company trips only
     * 
     */
    public function scopeCompanyTripsOnly($query, $company_id)
    {
        $company_trips = $query->whereHas('driver', function ($query) use ($company_id) {
            $query->where('company_id',$company_id);
        });
        return $company_trips;
    }

    /**
     * Get Trip additional fee reson
     * 
     */
    public function getTollFeeReasonAttribute()
    {
        $reason = '';
        if ($this->toll_reason_id) {
            $reason = $this->toll_reason->reason;
        }
        return $reason;
    }

    /**
     * Get Trip Other Reason
     * 
     */
    public function getTripTollFeeReasonAttribute()
    {
        $reason = '';
        if ($this->toll_reason_id && $this->toll_reason_id==1) {
            $reason = $this->trip_toll_reason->reason;
        }

        return $reason;
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Get trip details.
     *
     * @param  $user | json
     * @param  $paginate_limit | int
     * @param  $status | string
     * @param  $in | boolean
     * @return array
     */
    public static function getTripLists($user,$paginate_limit,$status,$in=true) {
        $trip_lists = self::select(
            \DB::raw("CASE WHEN trips.pool_id > 0 THEN 'true' ELSE 'false' END as is_pool"),
            'trips.seats',
            'trips.status',
            'trips.id as trip_id',
            'trips.pickup_location as pickup',
            'trips.drop_location as drop',
            'trips.map_image',
            \DB::raw("CASE 
                WHEN 
                schedule_ride.booking_type IS NOT NULL 
                THEN 
                schedule_ride.booking_type
                ELSE 
                ''
                END 
                as booking_type"
            ),
            'car_type.car_name as car_type',
            \DB::raw('"'.$user->currency->symbol.'" as currency_symbol'),
           
            \DB::raw("CASE 
                WHEN 
                profile_picture.src IS NOT NULL AND profile_picture.src!=''
                THEN 
                profile_picture.src
                ELSE 
                '".url('images/user.jpeg')."'
                END 
                as driver_image"
            ),
        )
        ->addSelect(\DB::raw("'' as schedule_display_date"))
        ->join('car_type','car_type.id','=','trips.car_id')
        ->join('currency', 'currency.code', '=', 'trips.currency_code')
        ->join('users', 'users.id', '=', 'trips.driver_id')
        ->leftJoin('profile_picture', 'profile_picture.user_id', '=', 'users.id')
        ->leftJoin('request', 'request.id', '=', 'trips.request_id')
        ->leftJoin('schedule_ride', 'schedule_ride.id', '=', 'request.schedule_id');

        if($user->user_type=='Driver')
            $trip_lists->where('trips.driver_id', $user->id);
        else
            $trip_lists->where('trips.user_id', $user->id);

        if($in)
            $trip_lists->whereIn('trips.status',$status);
        else
            $trip_lists->whereNotIn('trips.status',$status);

        return $trip_lists->orderBy('trips.id','DESC')->paginate($paginate_limit);
    }

    /**
     * Get weekly statements.
     *
     * @param  $user_id | int
     * @param  $currency_rate | int
     * @param  $currency_symbol | string
     * @param  $from_date | date
     * @param  $to_date | date
     * @return array
     */
    public static function getWeeklyStatement($user_id, $currency_rate, $currency_symbol, $from_date, $to_date) {
        return self::select(
            \DB::raw('CONCAT("'.$currency_symbol.'","",SUM(FORMAT((((trips.subtotal_fare + trips.driver_peak_amount + trips.tips + trips.waiting_charge + trips.toll_fee + trips.additional_rider_amount - trips.driver_or_company_commission) / currency.rate) * '.$currency_rate.'),2))) AS driver_earning'),
            \DB::raw('DATE_FORMAT(trips.created_at,"%d/%m") as format'),
            \DB::raw('DATE_FORMAT(trips.created_at,"%Y-%m-%d") as created_date'),
            \DB::raw('CONCAT("'.$currency_symbol.'","",SUM(FORMAT((((trips.driver_or_company_commission) / currency.rate) * '.$currency_rate.'),2))) AS driver_company_commission')
        )
        ->join('currency', 'currency.code', '=', 'trips.currency_code')
        ->where('trips.driver_id',$user_id)->where('trips.status','Completed')
        ->groupBy('trips.created_at')->orderBy('trips.created_at','DESC')->get();
    }

    /**
     * Get daily statements.
     *
     * @param  $user_id | int
     * @param  $currency_rate | int
     * @param  $currency_symbol | string
     * @param  $from_date | date
     * @param  $to_date | date
     * @param  $per_page | int
     * @return array
     */
    public static function getDailyStatement($user_id,$currency_rate,$currency_symbol,$from_date,$to_date,$per_page) {
        return self::select(
            'trips.id',
            \DB::raw('CONCAT("'.$currency_symbol.'","",FORMAT((((trips.subtotal_fare + trips.driver_peak_amount + trips.tips + trips.waiting_charge + trips.toll_fee + trips.additional_rider_amount - trips.driver_or_company_commission) / currency.rate) * '.$currency_rate.'),2)) AS driver_earning'),
            \DB::raw('DATE_FORMAT(trips.created_at,"%h:%i %p") as time'),
            \DB::raw('CONCAT("'.$currency_symbol.'","",FORMAT((((trips.driver_or_company_commission) / currency.rate) * '.$currency_rate.'),2)) AS driver_commission')
        )
        ->join('currency', 'currency.code', '=', 'trips.currency_code')
        ->whereBetween('trips.created_at', [$from_date, $to_date])->orderBy('trips.id','DESC')->paginate($per_page);
    }
}
