<?php

/**
 * Trip Controller

 * @subpackage  Controller
 * @category    Trip

 */

namespace App\Services;

use App\Models\Trips;
use App\Models\PoolTrip;
use App\Models\ReferralUser;
use App\Http\Helper\RequestHelper;
use Validator;
class BusinessLogic 
{


	public function validate($data,$user)
	{
		$method = 'for'.$data['pay_for'];
		return ($this)->$method($data,$user);
	}

	public function Fortrip($data,$user)
	{
		$rules = array(
			'trip_id' => 'required|exists:trips,id',
		);

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'status_code' => '0',
                'status_message' => $validator->messages()->first(),
            ];
        }

        return [
			'status_code' 		=> '1',
			'status_message' 	=> __('messages.success'),
		];

	}

	

}