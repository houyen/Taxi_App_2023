<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;

use App\Models\User;

class HomeController extends Controller
{
	/**
     * Get Common Data
     * 
     * @param  Get method request inputs
     *
     * @return Response Json 
     */
    public function commonData(Request $request)
    {
        $user_details = JWTAuth::parseToken()->authenticate();

        $site_settings = resolve('site_settings');
        $api_credentials = resolve('api_credentials');
        $fees = resolve('fees');

        $return_data = [
            'status_code'       => '1',
            'status_message'    => __('messages.api.listed_successfully'),
        ];

        $heat_map = $site_settings->where('name','heat_map')->first()->value;
        $heat_map = ($heat_map == 'On') ? 1:0;

        $sinch_key = $api_credentials->where('name','sinch_key')->first()->value;
        $sinch_secret_key = $api_credentials->where('name','sinch_secret_key')->first()->value;


        $referral_settings = resolve('referral_settings');
        $referral_settings = $referral_settings->where('user_type',ucfirst($request->user_type))->where('name','apply_referral')->first();

        $enable_referral = (@$referral_settings->value == "1");

        $apply_extra_fee = @$fees->where('name','additional_fee')->first()->value;
        $apply_trip_extra_fee = ($apply_extra_fee == 'Yes');

        $admin_contact  = MANUAL_BOOK_CONTACT;
        $google_map_key = MAP_SERVER_KEY;
        $fb_id          = FB_CLIENT_ID;

        $status = $user_details->status ?? 'Inactive';

        $gateway_type = "Stripe";


        $update_loc_interval = site_settings('update_loc_interval');
        $covid_future = site_settings('covid_enable') =='1' ? true:false;
        
        $trip_default = payment_gateway('trip_default','Common');

        $driver_km = site_settings('driver_km');
        $pickup_km = site_settings('pickup_km');
        $drop_km   = site_settings('drop_km');
//$common_data=[];
if($request->user_type == 'Rider') {
        $common_data = array(
                'sinch_key',
            'sinch_secret_key',
            'apply_trip_extra_fee',
            'admin_contact',
            'covid_future',
            //'arrival_time'        => $arrival_time,
        );
    }
        $common_data = compact(
            'heat_map',
            'sinch_key',
            'sinch_secret_key',
            'apply_trip_extra_fee',
            'admin_contact',
            'covid_future',
        );

        $driver_data = array();
        if($user_details->user_type == 'Driver' ) {
            $payout_methods = getPayoutMethods($user_details->company_id);
            
            foreach ($payout_methods as $payout_method) {
                $payout_list[] = ["key" => $payout_method, 'value' => snakeToCamel($payout_method)];
            }

           // $driver_data = compact('payout_list');
        }

        // get firebase token
        $user = User::find($user_details->id);

        $firebase = resolve("App\Services\FirebaseService");
        $firebase_token = $firebase->createCustomToken($user->email.' - '.$user->user_type);

        // save token
        $user->firebase_token = $firebase_token;
        $user->save();

        // return token
        $return_data['firebase_token'] = $firebase_token;
        $common_data['driver_request_seconds'] = site_settings('driver_request_seconds');

        return response()->json(array_merge($return_data,$common_data,$driver_data));
    }


}
