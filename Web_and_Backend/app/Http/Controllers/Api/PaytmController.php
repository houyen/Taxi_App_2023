<?php

/**
 * Trip Controller
 *
 * @package     NewTaxi
 * @subpackage  Controller
 * @category    Trip
 * @author      Seen Technologies
 * @version     2.2.1
 * @link        https://seentechs.com
 */

namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Payment;
use App\Models\Wallet;
use App\Models\User;
use App\Models\Trips;
use App\Models\PoolTrip;
use App\Models\DriverOweAmount;
use App\Models\ReferralUser;
use App\Models\AppliedReferrals;
use App\Models\DriverOweAmountPayment;
use App\Http\Helper\InvoiceHelper;
use App\Http\Helper\RequestHelper;
use App\Models\Transaction;
use Session;
class PaytmController extends Controller
{
    public function __construct(InvoiceHelper $invoice_helper)
	{
		$this->invoice_helper = $invoice_helper;
	}
	public function setSessonData($data,$user)
	{
        session()->forget('payment_data');
		$value['amount']                   = $data['amount'];
        $value['currency_code']            = $data['currency_code'];
        $value['payment_type']             = request()->payment_type;
        $value['user_token']               = request()->token;
        $value['pay_for']                  = request()->pay_for;
        $value['original_amount']          = request()->amount;
        $value['applied_referral_amount']  = request()->applied_referral_amount;
        $value['trip_id']                  = request()->trip_id;
        session()->put('payment_data',$value);
	}

	public function payment()
	{
		$user = $this->set_user_deatils();
		$this->setUserLocale($user->language);
		$data['currency_code'] = site_settings('payment_currency');
        $data['amount'] = currencyConvert($user->currency_code,$data['currency_code'],request()->amount);
        $this->setSessonData($data,$user);

        $business_logic = resolve('App\Services\BusinessLogic');
		$validate = $business_logic->validate(session()->get('payment_data'),$this->get_user_deatils());
		// only referal in pay to admin 
		if($validate['status_code']!='1')
		{
			if($validate['status_code']=='2')
				$return = $business_logic->pay_to_admin(session()->get('payment_data'),$this->get_user_deatils());
			else if($validate['status_code']=='3')
				$return = $business_logic->tripPayment(session()->get('payment_data'),$this->get_user_deatils());
			else 
				$return = response($validate);
			return $this->returnView($return);
		}

		$data['payment_method'] = $this->activePaymentMethod();
		foreach ($data['payment_method'] as  $key => $method) {
			try {
				$service = 'App\Services\Payments\\'.ucfirst($method)."Payment";
				$this->paymeny = resolve($service);
			}catch(\Exception $e) {
				$this->payment = resolve('App\Services\Payments\PaypalPayment');
	        }
	        $data['view'][$method] = $this->paymeny->view($user);
		}
		return view('payment.payment',$data);
	}
	public function activePaymentMethod()
	{
		$payment_gateway = resolve('payment_gateway');
		return $payment_gateway->where('site','!=','Cash')->where('name','is_enabled')->where('value','1')->pluck('site');
	}


	public function get_user_deatils()
	{
		if(session()->has('payment_data.user_token') || request()->token){
			if(request()->token){
				return \JWTAuth::parseToken()->authenticate();
			}
        	$set_token = \JWTAuth::setToken(session()->get('payment_data.user_token'));
			return  $set_token->toUser();
		}
		else
			return auth()->guard('web')->user();
	}
	public function set_user_deatils()
	{
		if(request()->token)
			return \JWTAuth::parseToken()->authenticate();
		else
			return auth()->guard('web')->user();
	}



	public function returnView($payment_status)
	{
		return view('web_payment.view',compact('payment_status'));
	}


	public function getSaveCardData($user,$payment_method='',$customer_id='')
    {

    	$card_details['payment_method'] = request()->paymentMethod_id;
    	if($customer_id!='')
    		$card_details['customer'] = $customer_id;

    	if($payment_method){
	        $card_details =  [
		                'customer'      => $payment_method->customer_id,
		                'payment_method'=> $payment_method->payment_method_id,
		            ];
		}
        $data['payment_data'] = array(
                'confirm'               => true,
                'off_session'           => true,
                'confirmation_method'   => 'manual',
                "amount"        		=> intval(session()->get('payment_data.amount') * 100),
                'currency'      		=> site_settings('payment_currency'),
                'description'   		=> session()->get('payment_data.pay_for').' Payment by '.$user->first_name,
            )+$card_details;
        $data['all_data'] = session()->get('payment_data');
        return $data;
    }


	public function getStripeData($service,$user)
	{
		//for 3d secure cards 
		if(request()->pay_key)
		{
			$data['payment_data'] = [];
			$data['all_data'] = session()->get('payment_data');
			return $data;
		}
		$card_details   = '';
		$customer_id   = '';
        if(request()->save_card_id || request()->save_card){
            if(request()->save_card && !request()->save_card_id){
                $payment_methods    = PaymentMethod::where('user_id',$user->id)->first();
                $customer_id        = $payment_methods ? $payment_methods->customer_id : '';

                if(!$customer_id)
                {
                    $customer = $service->createCustomer($user->email);
                    if($customer->status=='success')
                        $customer_id = $customer->customer_id;
                }
                $card_details = $this->saveNewCard($user,$customer_id,request()->paymentMethod_id,$service);
                if(isset($card_details['status_code']) && $card_details['status_code'] == "0") 
                	return $card_details;
            }
            else{
                $card_details = PaymentMethod::where('user_id',$user->id)->where('id',request()->save_card_id)->first();
            }
        }else{
        	$customer = $service->createCustomer($user->email);
                if($customer->status=='success')
                    $customer_id = $customer->customer_id;
            $attachCustomer = $service->attachCustomer($user,$customer_id,request()->paymentMethod_id);
            if( isset($attachCustomer['status_code']) && $attachCustomer['status_code'] == "0") 
                return $attachCustomer;
            $card_details = '';
        }
        return  $this->getSaveCardData($user,$card_details,$customer_id);

	}

	public function saveNewCard($user,$customer_id,$paymentMethod_id,$service)
    {
        $payment_details                = new PaymentMethod;
        $payment_details->user_id       = $user->id;
        $payment_details->customer_id   = $customer_id;
        $attach                         = $service->attachCustomer($user,$customer_id,$paymentMethod_id);
        if(isset($attach['status_code']) && $attach['status_code'] == "0") 
            return $attach;
        $payment_details->intent_id         = $attach['intent_id'];
        $payment_details->payment_method_id = $attach['payment_method_id'];
        $payment_details->brand             = $attach['brand'];
        $payment_details->last4             = $attach['last4'];
        $payment_details->save();
        
		//delete other cards
    	PaymentMethod::where('user_id',$user->id)->where('id','!=',$payment_details->id)->delete();
        return $payment_details;
    }



	public function getBraintreeData($service,$user)
	{
		$data['payment_data'] = session()->get('payment_data.amount');
        $data['key'] = request()->pay_key;
		$data['all_data'] = session()->get('payment_data');
        return $data;
	}
	public function getPaypalData($service,$user)
	{
		$data['payment_data'] = session()->get('payment_data.amount');
        $data['key'] = request()->pay_key;
		$data['all_data'] = session()->get('payment_data');
        return $data;
	}

	public function cancel()
	{
		$payment_status = array('status_code'=>'0','message'=>'Payment failed');
		return $this->returnView($payment_status);
	} 

	public function payment_action($payment,$paymentData)
	{
		$payment = json_decode(json_encode($payment),true);
		$data = array_merge($payment,$paymentData);

		$business_logic = resolve('App\Services\BusinessLogic');
		if($paymentData['pay_for']=='wallet')
			return $business_logic->add_wallet($data,$this->get_user_deatils());
		else if($paymentData['pay_for']=='pay_to_admin')
			return $business_logic->pay_to_admin($data,$this->get_user_deatils());
		else
			return $business_logic->tripPayment($data,$this->get_user_deatils());
	}



//PayTm

	public function paytm_payment(Request $request)
    {
        $user = $this->get_user_deatils();
        $order_id = uniqid();
        
        $payTm = new Transaction();
        $payTm->user_id =$user->id;
        $payTm->payment_id = $order_id;
        $payTm->payment_type = "paytm";
        $payTm->currency =  $user->currency_code;
        $payTm->amount = $request->amount;
        $payTm->pay_for = $request->pay_for;
        $payTm-> save();
      
	   $amount =$request->amount;

       $data_for_request = $this->handlePaytmRequest( $order_id, $amount);


       $paytm_txn_url = 'https://securegw-stage.paytm.in/theia/processTransaction';
       $paramList = $data_for_request['paramList'];
       $checkSum = $data_for_request['checkSum'];

       return view( 'payment.paytm', compact( 'paytm_txn_url', 'paramList', 'checkSum'));
    }

    public function handlePaytmRequest( $order_id, $amount ) {
		// Load all functions of encdec_paytm.php and config-paytm.php
		$this->getAllEncdecFunc();
		$this->getConfigPaytmSettings();
		
		$MID= payment_gateway('paytm_merchant','Paytm');
		$paytm_secret= payment_gateway('paytm_secret','Paytm');

		$checkSum = "";
		$paramList = array();

		// Create an array having all required parameters for creating checksum.
		$paramList["MID"] = $MID;
		$paramList["ORDER_ID"] = $order_id;
		$paramList["CUST_ID"] = $order_id;
		$paramList["INDUSTRY_TYPE_ID"] = 'Retail';
		$paramList["CHANNEL_ID"] = 'WEB';
		$paramList["TXN_AMOUNT"] = $amount;
		$paramList["WEBSITE"] = 'WEBSTAGING';
		$paramList["CALLBACK_URL"] = url( '/api/paytm_callback' );
		$paytm_merchant_key = $paytm_secret;

		//Here checksum string will return by getChecksumFromArray() function.
		$checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );

		return array(
			'checkSum' => $checkSum,
			'paramList' => $paramList
		);
	}



	public function getAllEncdecFunc() {
        function encrypt_e($input, $ky) {
            $key   = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $iv );
            return $data;
        }
        
        function decrypt_e($crypt, $ky) {
            $key   = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_decrypt ( $crypt , "AES-128-CBC" , $key, 0, $iv );
            return $data;
        }
        
        function generateSalt_e($length) {
            $random = "";
            srand((double) microtime() * 1000000);
        
            $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
            $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
            $data .= "0FGH45OP89";
        
            for ($i = 0; $i < $length; $i++) {
                $random .= substr($data, (rand() % (strlen($data))), 1);
            }
        
            return $random;
        }
        
        function checkString_e($value) {
            if ($value == 'null')
                $value = '';
            return $value;
        }
        
        function getChecksumFromArray($arrayList, $key, $sort=1) {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        function getChecksumFromString($str, $key) {
            
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        
        function verifychecksum_e($arrayList, $key, $checksumvalue) {
            $arrayList = removeCheckSumParam($arrayList);
            ksort($arrayList);
            $str = getArray2StrForVerify($arrayList);
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);
        
            $finalString = $str . "|" . $salt;
        
            $website_hash = hash("sha256", $finalString);
            $website_hash .= $salt;
        
            $validFlag = "FALSE";
            if ($website_hash == $paytm_hash) {
                $validFlag = "TRUE";
            } else {
                $validFlag = "FALSE";
            }
            return $validFlag;
        }
        
        function verifychecksum_eFromStr($str, $key, $checksumvalue) {
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);
        
            $finalString = $str . "|" . $salt;
        
            $website_hash = hash("sha256", $finalString);
            $website_hash .= $salt;
        
            $validFlag = "FALSE";
            if ($website_hash == $paytm_hash) {
                $validFlag = "TRUE";
            } else {
                $validFlag = "FALSE";
            }
            return $validFlag;
        }
        
        function getArray2Str($arrayList) {
            $findme   = 'REFUND';
            $findmepipe = '|';
            $paramStr = "";
            $flag = 1;	
            foreach ($arrayList as $key => $value) {
                $pos = strpos($value, $findme);
                $pospipe = strpos($value, $findmepipe);
                if ($pos !== false || $pospipe !== false) 
                {
                    continue;
                }
                
                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }
        
        function getArray2StrForVerify($arrayList) {
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }
        
        function redirect2PG($paramList, $key) {
            $hashString = getchecksumFromArray($paramList);
            $checksum = encrypt_e($hashString, $key);
        }
        
        function removeCheckSumParam($arrayList) {
            if (isset($arrayList["CHECKSUMHASH"])) {
                unset($arrayList["CHECKSUMHASH"]);
            }
            return $arrayList;
        }
        
        function getTxnStatus($requestParamList) {
            return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
        }
        
        function getTxnStatusNew($requestParamList) {
            return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
        }
        
        function initiateTxnRefund($requestParamList) {
            $CHECKSUM = getRefundChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY,0);
            $requestParamList["CHECKSUM"] = $CHECKSUM;
            return callAPI(PAYTM_REFUND_URL, $requestParamList);
        }
        
        function callAPI($apiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                         
            'Content-Type: application/json', 
            'Content-Length: ' . strlen($postData))                                                                       
            );  
            $jsonResponse = curl_exec($ch);   
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }
        
        function callNewAPI($apiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                         
            'Content-Type: application/json', 
            'Content-Length: ' . strlen($postData))                                                                       
            );  
            $jsonResponse = curl_exec($ch);   
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }

        function getRefundChecksumFromArray($arrayList, $key, $sort=1) {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getRefundArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }


        function getRefundArray2Str($arrayList) {	
            $findmepipe = '|';
            $paramStr = "";
            $flag = 1;	
            foreach ($arrayList as $key => $value) {		
                $pospipe = strpos($value, $findmepipe);
                if ($pospipe !== false) 
                {
                    continue;
                }
                
                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }
        function callRefundAPI($refundApiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);	
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $refundApiURL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
            $jsonResponse = curl_exec($ch);   
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }
    }

    public function getConfigPaytmSettings() {
        
        $MID= payment_gateway('paytm_merchant','Paytm');
		$paytm_secret= payment_gateway('paytm_secret','Paytm');
		$paytm_mode= payment_gateway('mode','Paytm');
		
        define('PAYTM_ENVIRONMENT', $paytm_mode); // PROD
		define('PAYTM_MERCHANT_KEY', $paytm_secret); //Change this constant's value with Merchant key received from Paytm.
		define('PAYTM_MERCHANT_MID', $MID); //Change this constant's value with MID (Merchant ID) received from Paytm.
		define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm.

		$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
		$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
		if (PAYTM_ENVIRONMENT == 'live') {
			$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
			$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
		}

		define('PAYTM_REFUND_URL', '');
		define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
		define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
		define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
    }

    public function paytm_callback( Request $request ) {
		$order_id = $request['ORDERID'];

		if ( 'TXN_SUCCESS' === $request['STATUS'] ) {
			$transaction_id = $request['TXNID'];
			$paytm_payment = Transaction::where('payment_id',$request['ORDERID'])->where('status','Pending')->latest();
			$user = User::where('id',$paytm_payment->user_id)->first();
			if($paytm_payment){
			    if($paytm_payment->pay_for=="wallet"){
			        
			        
			        $wallet = Wallet::whereUserId($paytm_payment->user_id)->first();
			        

                    $wallet_amount = $paytm_payment->amount;
            		if($wallet) {
            			$wallet_amount = floatval($wallet->original_amount) + floatval($wallet_amount);
            		}
            		else {
            			$wallet = new Wallet;
            		}
            
            		$wallet->amount = $wallet_amount;
            		$wallet->paykey = $transaction_id;
            		$wallet->currency_code = $user->currency_code;
            		$wallet->user_id = $user->id;
            		$wallet->save();
            
            	
			         $paymentData = ([
				     'status_code' => '1',
					 'status_message' 	=> __('messages.wallet_add_success'),
					 'wallet_amount' 	=>  (string) floatval($wallet_amount),
			        ]);
			        return $this->returnView($paymentData);
			        
			    }else if($paytm_payment->pay_for=="pay_to_admin"){
			        
			      $owe_amount = DriverOweAmount::where('user_id', $user->id)->first();
		if ($owe_amount && $owe_amount->amount > 0) {
		

			//pay to admin from payout preference start
			$owe_amount = DriverOweAmount::where('user_id', $user->id)->first();

			$amount = $paytm_payment->amount;


			if($amount > 0) {
				if($owe_amount->amount < $amount) {
				
					$paymentData = ([
				    'status_code' => '0',
					'status_message' => trans('messages.api.invalid'),
					
			        ]);
			        return $this->returnView($paymentData);
				}


				$owe_amount = DriverOweAmount::where('user_id', $user->id)->first();
				$total_owe_amount = $owe_amount->amount;
				$currency_code = $owe_amount->currency_code;
				$remaining_amount = $total_owe_amount - $amount;

				$currency_code = $user->currency_code;
				


				//owe amount
				$owe_amount->amount = $remaining_amount;
				$owe_amount->currency_code = $currency_code;
				$owe_amount->save();

				$payment = new DriverOweAmountPayment;
				$payment->user_id = $user->id;
				$payment->transaction_id = $transaction_id;
				$payment->amount = $paytm_payment->amount;
				$payment->status = 1;
				$payment->currency_code = $currency_code;
				$payment->save();

				$owe_amount = DriverOweAmount::where('user_id', $user->id)->first();
			}

			$referral_amount = ReferralUser::where('user_id',$user->id)->where('payment_status','Completed')->where('pending_amount','>',0)->get();
			$referral_amount = number_format($referral_amount->sum('pending_amount'),2,'.','');

			
			 $paymentData = ([
				'status_code' 	=> '1',
				'status_message'=> __('messages.payment_complete_success'),
				'referral_amount' => $referral_amount,
				'owe_amount' 	=> $owe_amount->amount,
				'currency_code' => $owe_amount->currency_code,
			     ]);
			 return $this->returnView($paymentData);
	        	}
			        
			      $paymentData = ([
				 'status_code' => '0',
			     'status_message' => __('messages.api.not_generate_amount'),
			     ]);
                 return $this->returnView($paymentData);   
			        
			        
			        
			    }else if($paytm_payment->pay_for=="trip"){
			        $trip_id = Trips::where('user_id',$user->id)->where('payment_status',"Pending")->where('payment_mode',"paytm")->latest();
			        $trip = Trips::find($trip_id->id); 

            		if($trip->is_calculation == 0) {
            			$data = [
            				'trip_id' => $trip->id,
            				'user_id' => $user->id,
            				'save_to_trip_table' => 1,
            			];
            			$trip = $this->invoice_helper->calculation($data);
            		}
            
            		$trip->status = 'Completed';
            		$trip->paykey = $transaction_id ?? '';
            		$trip->payment_status = 'Completed';
            		$trip->save();
            
            		if($trip->pool_id>0) {
            
            			$pool_trip = PoolTrip::with('trips')->find($trip->pool_id);
            			$trips = $pool_trip->trips->whereIn('status',['Scheduled','Begin trip','End trip','Rating','Payment'])->count();
            			
            			if(!$trips) {
            				// update status
            				$pool_trip->status = 'Completed';
            				$pool_trip->save();
            			}
            		}
            
            		$data = [
            			'trip_id' => $trip->id,
            			'correlation_id' => $pay_result->transaction_id ?? '',
            			'driver_payout_status' => ($trip->driver_payout) ? 'Pending' : 'Completed',
            		];
            		Payment::updateOrCreate(['trip_id' => $trip->id], $data);
            
            		//Push notification 
            		$push_title = "Payment Completed";
            		$push_data['push_title'] = $push_title;
                    $push_data['data'] = array(
                    	'trip_payment' => array(
                    		'status' => 'Paid',
                    		'trip_id' => $trip->id,
                    		'rider_thumb_image' => $trip->rider_profile_picture
                    	)
                    );
                    $request_helper = new RequestHelper();
                    $request_helper->SendPushNotification($trip->driver,$push_data);
            
            	
            		$paymentData = ([
    				'status_code' => '1',
    				'status_message' 	=> __('messages.payment_complete_success'),
        			]);
        			return $this->returnView($paymentData);
			        
			        
			    }
			    
			}
		
			

		} else if( 'TXN_FAILURE' === $request['STATUS'] ){
			$paymentData = ([
				'status_code' => '0',
				'status_message' => trans($request['RESPMSG']),
			]);
			return $this->returnView($paymentData);
		}
	}


	

	public function setUserLocale($locale)
	{
		App::setLocale($locale);
        Session::put('language', $locale);
	}


}