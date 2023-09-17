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
use JWTAuth;
use Carbon\Carbon;
class MpesaController extends Controller
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




	
	public static function mpesa(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $payment_id = uniqid();
        
        $amount = $request->amount;
       
       
        $data['currency_code'] = 'KES';
        if($user->currency_code !="KES"){
           $amount = currencyConvert($user->currency_code,$data['currency_code'],request()->amount);  
        }
        $payable_amount = intval(round($amount));
        $data['amount'] =   $payable_amount;
		$data['currency_code'] = 'KES';
		$data['payment_type'] = 'mpesa';
		$data['pay_for'] = $request->pay_for;
		$data['token'] = $request->token;
		$data['user_id'] = $user->id;
	

		//return array('view'=>'paypal','data'=>$data);
		return view('payment.mpesa',$data);
    
    }
	
	// Initiate Mpesa
	
	public function lipaNaMpesaPassword()
    {
        $lipa_time = Carbon::rawParse('now')->format('YmdHms');
        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $BusinessShortCode = 174379;
        $timestamp =$lipa_time;

        $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);
        return $lipa_na_mpesa_password;
    }
	/**
     * Lipa na M-PESA STK Push method
     * */

    public function customerMpesaSTKPush(Request $request)
    {
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $phone_number= $request->phone_number;
		//$phone_final=substr($phone_number, -9);
		
		$phone_final = substr($phone_number, -9);
        $added_value = 254; // Replace this with the value you want to add
        $phone_final = $added_value . $phone_final;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken()));


        $curl_post_data = [
            //Fill in the request parameters with valid values
            'BusinessShortCode' => payment_gateway('business_shortcode','Mpesa'),
            'Password' => $this->lipaNaMpesaPassword(),
            'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $request->amount,
            'PartyA' => $phone_final, // replace this with your phone number
            'PartyB' => payment_gateway('business_shortcode','Mpesa'),
            'PhoneNumber' => $phone_final, // replace this with your phone number
            'CallBackURL' => payment_gateway('callback_url','Mpesa'),
            'AccountReference' => "New Taxi",
            'TransactionDesc' => "New Taxi Payment"
        ];

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);
        $Checkout=json_decode($curl_response);
        
     
        $user_id=$request->user_id;
        $Transaction = new Transaction();
        $Transaction->user_id =$request->user_id;
        $Transaction->payment_id =$Checkout->CheckoutRequestID??"";
        $Transaction->amount = $request->amount;
        $Transaction->payment_type = "mpesa";
        $Transaction->currency =  $request->currency_code;
        $Transaction->pay_for = $request->pay_for;
        $Transaction-> save();
        //check if user input the correct phone number
        $check_phone_number=Transaction::find($Transaction->id);
        if($check_phone_number->payment_id=="" ||$check_phone_number->payment_id==null){
             $paymentData = ([
    				'status_code' => '0',
    				'status_message' 	=> __('Kindly enter correct phone number and retry again!'),
        			]);
        	//delete the row and return response		
        	$check_phone_number->delete();
        	return $this->returnView($paymentData);
        }else{
            return $this->mpesaSuccess($request->user_id);
        }
        
        
    }


    public function generateAccessToken()
    {
        
        $consumer_key=payment_gateway('consumer_key','Mpesa');
        $consumer_secret=payment_gateway('consumer_secret','Mpesa');
        $credentials = base64_encode($consumer_key.":".$consumer_secret);

        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials));
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);
        $access_token=json_decode($curl_response);
        return $access_token->access_token;
    }


    /**
     * J-son Response to M-pesa API feedback - Success or Failure
     */
    public function createValidationResponse($result_code, $result_description){
        $result=json_encode(["ResultCode"=>$result_code, "ResultDesc"=>$result_description]);
        $response = new Response();
        $response->headers->set("Content-Type","application/json; charset=utf-8");
        $response->setContent($result);
        return $response;
    }


    /**
     *  M-pesa Validation Method
     * Safaricom will only call your validation if you have requested by writing an official letter to them
     */

    public function mpesaValidation(Request $request)
    {
        $result_code = "0";
        $result_description = "Accepted validation request.";
        return $this->createValidationResponse($result_code, $result_description);
    }

    /**
     * M-pesa Transaction confirmation method, we save the transaction in our databases
     */

  
     public function mpesaConfirmation( Request $request ) {
         
       
		$body = $request->getContent();
		
		
        $data = json_decode($body);
        
        $resultCode=$data->Body->stkCallback->ResultCode;
        $resultDesc=$data->Body->stkCallback->ResultDesc;
       
        
         $CheckoutRequestID=$data->Body->stkCallback->CheckoutRequestID;
            $Transaction= Transaction::where('payment_type',"mpesa")->where('payment_id',$CheckoutRequestID)->where('status',"Pending")->latest()->first();;
            if($Transaction){
            $user = $Transaction->user_id;
            $mpesa_transaction = Transaction::find($Transaction->id); // Find the record with id = 1
            }
        //Check Payment Status
        if($resultCode=="0"){
           
            // Extract relevant data from the callback
            $mpesaReceiptNumber = $data->Body->stkCallback->CallbackMetadata->Item[1]->Value;
            $transactionDate = $data->Body->stkCallback->CallbackMetadata->Item[3]->Value;
            
            if ($mpesa_transaction) {
                $mpesa_transaction->status = 'Paid'; // Set the new value for the status
                $mpesa_transaction->transaction_id =  $mpesaReceiptNumber;
                $mpesa_transaction->payment_desc =  $resultDesc;
                $mpesa_transaction->save(); // Save the changes to the database
            }
            
        }else if($resultCode=="1032"){
         
            if ($mpesa_transaction) {
                $mpesa_transaction->status = 'Failed'; // Set the new value for the status
                $mpesa_transaction->payment_desc =  $resultDesc;
                $mpesa_transaction->save(); // Save the changes to the database
            }
           
        }else if($resultCode=="1"){
           
            if ($mpesa_transaction) {
                $mpesa_transaction->status = 'Failed'; // Set the new value for the status
                $mpesa_transaction->payment_desc =  $resultDesc;
                $mpesa_transaction->save(); // Save the changes to the database
            }
            
        }

	
	}
	
	


    /**
     * M-pesa Register Validation and Confirmation method
     */
    public function mpesaRegisterUrls()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '. $this->generateAccessToken()));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
            'ShortCode' => "600141",
            'ResponseType' => 'Completed',
            'ConfirmationURL' => "https://blog.hlab.tech/api/v1/hlab/transaction/confirmation",
            'ValidationURL' => "https://blog.hlab.tech/api/v1/hlab/validation"
        )));
        $curl_response = curl_exec($curl);
        echo $curl_response;
    }
    
    //Mpesa Check payment status and store
   public function mpesaSuccess($user_id)
   {
    
    $ifsuccessful = false;
    $response = null;
    $user =User::where('id',$user_id)->first();
    // set Execution Time
    $start = microtime(true);

    while (!$ifsuccessful) {
        // Run your query here
        $result = Transaction::where('user_id', $user_id)->latest()->first(); 

        // Check if the condition is met
        if ($result && $result->status == 'Failed') {
            $ifsuccessful = true;
             $response  = ([
				'status_code' => '0',
				'status_message' => trans($result->payment_desc),
			]);
			return $this->returnView($response);
           
        } else if($result && $result->status == 'Paid') {
             if($result->pay_for=="wallet"){
			        
			        
			        $wallet = Wallet::whereUserId($result->user_id)->first();
			        

                    $wallet_amount = $result->amount;
            		if($wallet) {
            			$wallet_amount = floatval($wallet->original_amount) + floatval($wallet_amount);
            		}
            		else {
            			$wallet = new Wallet;
            		}
            
            		$wallet->amount = $wallet_amount;
            		$wallet->paykey = $result->transaction_id;
            		$wallet->currency_code = $user->currency_code;
            		$wallet->user_id = $user_id;
            		$wallet->save();
            
            	
			         $paymentData = ([
				     'status_code' => '1',
					 'status_message' 	=> __('messages.wallet_add_success'),
					 'wallet_amount' 	=>  (string) floatval($wallet_amount),
			        ]);
			        return $this->returnView($paymentData);
			        
			    }else if($result->pay_for=="pay_to_admin"){
			        
			        $owe_amount = DriverOweAmount::where('user_id', $user_id)->first();
            		if ($owe_amount && $owe_amount->amount > 0) {
            		
            
            			//pay to admin from payout preference start
            			$owe_amount = DriverOweAmount::where('user_id', $user_id)->first();
            
            			$amount = $result->amount;
            
            
            			if($amount > 0) {
            				if($owe_amount->amount < $amount) {
            				
            					$paymentData = ([
            				    'status_code' => '0',
            					'status_message' => trans('messages.api.invalid'),
            					
            			        ]);
            			        return $this->returnView($paymentData);
            				}
            
            
            				$owe_amount = DriverOweAmount::where('user_id', $user_id)->first();
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
            				$payment->transaction_id = $result->transaction_id;
            				$payment->amount = $result->amount;
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
            			        
            			        
            			        
			    }else if($result->pay_for=="trip"){
			        $trip_id = Trips::where('user_id',$user->id)->where('payment_status',"Pending")->where('payment_mode',"mpesa")->latest()->first();
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
            		$trip->paykey = $result->transaction_id ?? '';
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
		
		$elapsedTime = microtime(true) - $start; // Calculate elapsed time in seconds

        // Check if the timeout duration (in seconds) has been exceeded
        $timeout = 25; // Set your desired timeout duration in seconds
        if ($elapsedTime >= $timeout) {
            $paymentData = ([
    				'status_code' => '0',
    				'status_message' 	=> __('Payment was not successful, kindly try again!'),
        			]);
        	return $this->returnView($paymentData);
        }
        }
    }

  



   public function returnView($payment_status)
	{
		return view('web_payment.view',compact('payment_status'));
	}


	public function setUserLocale($locale)
	{
		App::setLocale($locale);
        Session::put('language', $locale);
	}


}