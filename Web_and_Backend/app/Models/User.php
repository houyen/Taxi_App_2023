<?php

/**
 * User Model

 * @subpackage  Model
 * @category    User

 */

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Models\Country;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DateTime;
use JWTAuth;
use DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\CurrencyConversion;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password',];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'string',
    ];

    protected $appends = ['car_type','latitude','longitude','date_time_join','phone_number','total_earnings','total_rides','total_commission','hidden_mobile_number','company_name','gender_text'];

    /**
    * @var array
    */
    protected $genders = [
        1 => 'male',
        2 => 'female'
    ];

    // JWT Auth Functions Start
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
    // JWT Auth Functions End

    /**
    * @param int $value
    * @return string|null
    */
    public function getGenderTextAttribute() {
        return $this->attributes['gender'] ? (request()->segment(1)=='api' ? \Arr::get($this->genders, $this->attributes['gender']):__('messages.profile.'.\Arr::get($this->genders, $this->attributes['gender']))):'';
    }

    /**
     * Scope to get Active records Only
     *
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    /**
     * Scope to get Active records with Strict mode
     *
     */
    public function scopeActiveOnlyStrict($query)
    {
        return $query->active()
            ->whereHas('vehicle',function($query) {
                $query->active();
            })
            ->whereHas('company',function($query) {
                $query->active();
            });
    }

    /**
     * Scope to get Admin drivers only
     *
     */
    public function scopeAdminCompany($query)
    {
        return $query->where('company_id', '1');
    }

    /**
     * Set password
     *
     */
    public function setPasswordAttribute($input)
    {
        $this->attributes['password'] = bcrypt($input);
    }

    // Join with profile_picture table
    public function profile_picture()
    {
        return $this->belongsTo('App\Models\ProfilePicture','id','user_id');
    }


    // Join with vehicle table
    public function vehicle()
    {
        return $this->hasOne('App\Models\Vehicle','user_id','id')->where('default_type', '1');
    }

    // Join with vehicle table
    public function vehicles()
    {
        return $this->hasMany('App\Models\Vehicle','user_id','id');
    }

    // Join with driver_documents table
    public function driver_documents($type=false)
    {
        $driver_documents = $this->belongsTo('App\Models\DriverDocuments','id','user_id');
        if($type) {
            $driver_documents->whereType($type);
        }
        return $driver_documents;
    }

    // Join with driver_location table
    public function driver_location()
    {
        return $this->belongsTo('App\Models\DriverLocation','id','user_id');
    }

    // Join with driver_documents table
    public function driver_address()
    {
        return $this->belongsTo('App\Models\DriverAddress','id','user_id');
    }

    // Join with driver_documents table
    public function rider_location()
    {
        return $this->belongsTo('App\Models\RiderLocation','id','user_id');
    }

    // Join with trips table
    public function driver_trips()
    {
        return $this->hasMany('App\Models\Trips','driver_id','id');
    }

    //Join with country
    public function country_name()
    {
        $data = Country::where('phone_code',@$this->attributes['country_code'])->first();
        if($data)
            return $data->long_name;    
    }

    // facebook authenticate 
    public static function user_facebook_authenticate($email, $fb_id){
        $user = User::where(function($query) use($email, $fb_id){
            $query->where('email', $email)->orWhere('fb_id', $fb_id);
        });
        return $user;
    }

    // Check Email and Google ID
    public static function user_google_authenticate($email, $google_id)
    {
        $user = User::where('user_type','Rider')->where(function($query) use($email, $google_id) {
            $query->where('email', $email)->orWhere('google_id', $google_id);
        });
        return $user;
    }

    // get latitude
    public function getLatitudeAttribute(){
        $user_type = @$this->attributes['user_type'];

        if($user_type == 'Driver')
        {
            $latitude = @DriverLocation::where('user_id',@$this->attributes['id'])->first()->latitude;
        }
        else
        {
            $latitude = @RiderLocation::where('user_id',@$this->attributes['id'])->first()->latitude;
        }

        return @$latitude;

    }

    // get longitude
    public function getLongitudeAttribute(){
        $user_type = @$this->attributes['user_type'];

        if($user_type == 'Driver')
        {
            $longitude = @DriverLocation::where('user_id',@$this->attributes['id'])->first()->longitude;
        }
        else
        {
            $longitude = @RiderLocation::where('user_id',@$this->attributes['id'])->first()->longitude;
        }

        return @$longitude;
    }

    // Get header picture source URL based on photo_source
    public function getCarTypeAttribute()
    {
        $vehicle = $this->vehicle;
        $car_type = null;
        if($vehicle != '') {
            $car_type = $vehicle->car_type;
        }
        if($this->vehicles->count()) {
            $car_type = $this->vehicles->first()->car_type;
        }
        return optional($car_type)->car_name ?? '';
    }

    // Get phone number attribute
    public function getPhoneNumberAttribute()
    {
        return "+".@$this->attributes['country_code'].@$this->attributes['mobile_number'];
    }

    public function getDateTimeJoinAttribute()
    {
        $full = false;

        $now = new DateTime;
        $ago = new DateTime(@$this->attributes['created_at']);
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

    /**
     * Get Total Trips
     * 
     */
    public function getTotalRidesAttribute()
    {
        $total_rides=DB::table('trips')->where('driver_id',$this->attributes['id']);
        return $total_rides->count();
    }

    /**
     * Get Total Earnings
     * 
     */
    public function getTotalEarningsAttribute()
    {
        $total_rides = Trips::where('trips.driver_id',$this->attributes['id'])
        ->join('currency', 'currency.code', '=', 'trips.currency_code');

        $currency_code = CurrencyConversion::getSessionOrDefaultCode();
        $currency_rate = Currency::whereCode($currency_code)->first()->rate;

        if($total_rides->count()) {
            $total_amount = $total_rides->sum(\DB::raw('FORMAT((((trips.subtotal_fare + trips.driver_peak_amount + trips.tips + trips.waiting_charge + trips.toll_fee + trips.additional_rider_amount - trips.driver_or_company_commission) / currency.rate) * '.$currency_rate.'),2)'));
            return $total_amount;
        } else {
            return number_format(0,2);
        }
    }

    /**
     * Get Total Commision
     * 
     */
    public function getTotalCommissionAttribute()
    {
        $total_rides = Trips::where('driver_id',$this->attributes['id'])
        ->join('currency', 'currency.code', '=', 'trips.currency_code');

        $currency_code = CurrencyConversion::getSessionOrDefaultCode();
        $currency_rate = Currency::whereCode($currency_code)->first()->rate;

        if($total_rides->count()) {
            $total_amount = $total_rides->sum(\DB::raw('FORMAT((((trips.access_fee + trips.peak_amount - trips.driver_peak_amount + trips.schedule_fare + trips.driver_or_company_commission) / currency.rate) * '.$currency_rate.'),2)'));
            return $total_amount;
        } else {
            return number_format(0,2);
        }
    }

    /**
     * Get Total Company commission
     * 
     */
    public function getTotalCompanyAdminCommissionAttribute()
    {
        $total_rides=Trips::where('driver_id',$this->attributes['id'])->get();
        if($total_rides->count())
        {
            $total_amount = $total_rides->sum(function ($trip) {
                return $trip->company_admin_commission;
            });

            return $total_amount;
        }
        else
        {
            return number_format(0,2);
        }
    }

    /**
     * Get Currency code
     * 
     */
  /*  public function getCurrencyAttribute()
    {
        $currency_code = $this->attributes['currency_code'];
        $currency = Currency::where('code', $currency_code)->first();
        if($currency == '') {
            $currency = Currency::defaultCurrency()->first();
            User::where('id', $this->attributes['id'])->update(['currency_code' => $currency->code]);
        }
        return $currency;
    }*/

        /**
     * Get Session or Default Currency code
     *
     */
    public  function getCurrencyAttribute()
    {
        if(request()->segment(1) == 'api') {
            if(request('token')) {
                try {
                    $currency_code = JWTAuth::toUser(request()->token)->currency_code;
                }
                catch(\Exception $e) {
                    $currency_code = Currency::defaultCurrency()->first();
                }
            }
            else {
                $currency_code = Currency::defaultCurrency()->first();
            }
        }
        else {
            $currency_code = session()->get('currency');  
        }

        return  is_string($currency_code)   ? Currency::where('code',$currency_code)->first():$currency_code;
    }

    // Get Translated Status Attribute
    public function getTransStatusAttribute()
    {
        return trans('messages.driver_dashboard.'.$this->attributes['status']);
    }


    // Get Mobile number with Protected format
    public function getHiddenMobileNumberAttribute()
    {

        $protected_number = '-';
        if(!isset($this->attributes['mobile_number'])){
            return $protected_number;
        }
        $mobile_number = $this->attributes['mobile_number'];
        if($mobile_number != '') {
            if(isLiveEnv()) {
             $protected_number = str_replace(range(0,9), "*", substr($mobile_number, 0, -4)) .  substr($mobile_number, -4);
            }
            else
            {
               $protected_number =  $this->attributes['mobile_number'];
            }
        }

        return $protected_number;
    }


    /**
     * Get Full name
     * 
     */
    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Get mobile number based on env
     * 
     */
    public function getEnvMobileNumberAttribute()
    {
        if(isLiveEnv()) {
            return '';
        }
        return $this->mobile_number;
    }

    // Get email attribute
    public function getEmailAttribute()
    {
        if(isLiveEnv() && isAdmin()) {
            return substr($this->attributes['email'], 0, 1) . '****' . substr($this->attributes['email'],  -4);
        }
        return $this->attributes['email'];
    }

    // phone number restrictions
    public function getMobileNumberAttribute()
    {
        if(isLiveEnv() && isAdmin()) {
            return substr($this->attributes['mobile_number'], 0, 1) . '****' . substr($this->attributes['mobile_number'],  -4);
        }
        return $this->attributes['mobile_number'];
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

    // Join with country table
    public function country()
    {
        return $this->belongsTo('App\Models\Country','country_id','id');
    }
}
