<?php

/**
 * Payment Gateway Controller
 *
 * @package     SGTaxi
 * @subpackage  Controller
 * @category    Payment Gateway


 * 
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;

class PaymentGatewayController extends Controller
{
    /**
     * Load View and Update Payment Gateway Data
     *
     * @return redirect to payment_gateway
     */
    public function index(Request $request)
    {
        if($request->isMethod('GET')) {
            return view('admin.payment_gateway');
        }

        $paypal_rules = array();
        $stripe_rules = array();
        $bt_rules = array();
        $paytm_rules = array();

        if($request->paypal_enabled) {
            $paypal_rules = array(
                'paypal_id'         => 'required',
                'paypal_mode'       => 'required',
                'paypal_client'     => 'required',
                'paypal_secret'     => 'required',
                'paypal_access_token'=> 'required',
            );
        }
        if($request->flutterwave_enabled) {
            $paypal_rules = array(
                'flutterwave_public_key'=> 'required',
                'flutterwave_secret_key' => 'required',
                'flutterwave_encryption_key' => 'required',
                'flutterwave_mode'       => 'required',
            );
        }
        
        if($request->mpesa_enabled) {
            $mpesa_rules = array(
                'mpesa_mode'         => 'required',
                'consumer_key'       => 'required',
                'consumer_secret'    => 'required',
                'callback_url'       => 'required',
                'business_shortcode' => 'required',
                
            );
        }
        
        if($request->paytm_enabled) {
            $paytm_rules = array(
                'paytm_merchant'=> 'required',
                'paytm_secret' => 'required',
                'paytm_mode'       => 'required',
            );
        }
        
        if($request->mollie_enabled) {
            $paytm_rules = array(
                'mollie_key'     => 'required',
                'mollie_partner' => 'required',
                'mollie_profile' => 'required',
                'mollie_mode'    => 'required',
            );
        }

        if($request->stripe_enabled) {
            $stripe_rules = array(
                'stripe_publish_key'=> 'required',
                'stripe_secret_key' => 'required',
                'stripe_api_version' => 'required',
            );
        }
        if($request->bt_enabled) {
            $bt_rules = array(
                'bt_mode'           => 'required',
                'bt_merchant_id'    => 'required',
                'bt_public_key'     => 'required',
                'bt_private_key'    => 'required',
                'tokenization_key'  => 'required',
            );
        }
        $rules = array_merge($paypal_rules,$paytm_rules,$stripe_rules,$bt_rules);

        // Payment Gateway Validation Custom Names
        $attributes = array(
            'paypal_id'         => 'PayPal ID',
            'paypal_mode'       => 'PayPal Mode',
            'paypal_client'     => 'PayPal Client',
            'paypal_secret'     => 'PayPal Secret',
            'paypal_access_token'=> 'PayPal Access Token',
            'stripe_publish_key'=> 'Stripe Publish Key',
            'stripe_secret_key' => 'Stripe Secret Key',
            'stripe_api_version'=> 'Stripe API Version',
            'flutterwave_public_key'=> 'Flutterwave Public Key',
            'flutterwave_secret_key' => 'Flutterwave Secret Key',
            'flutterwave_encryption_key'=> 'Flutterwave Encryption Key',
            'flutterwave_mode'       => 'Flutterwave Mode',
            'paytm_merchant'=> 'Paytm Merchant',
            'paytm_secret'=> 'Paytm Secret',
            'paytm_mode'       => 'Paytm Mode',
            'bt_mode'           => 'Payment Mode',
            'bt_merchant_id'    => 'Merchant ID',
            'bt_public_key'     => 'Public Key',
            'bt_private_key'    => 'Private Key',
            'consumer_key'      => 'Mpesa Consumer Key',
            'mpesa_mode'       => 'Mpesa Mode',
            'consumer_secret'   => 'Mpesa Consumer Secret',
            'callback_url'      => 'Mpesa Callback Url',
            'business_shortcode' => 'Mpesa Business Shortcode',
            'mollie_partner'         => 'Mollie Partner ID',
            'molie_mode'       => 'Mollie Mode',
            'mollie_key'     => 'Mollie Api Key',
            'mollie_profile'     => 'Mollie  Profile',
        );

        if($request->stripe_enabled && $request->bt_enabled) {
            flashMessage('danger', 'Please Choose either Braintree or Stripe for Card Payments');
            return back();
        }

        if($request->stripe_enabled == '0' && $request->bt_enabled == '0' && $request->paypal_enabled == '0' && $request->paytm_enabled == '0') {
            flashMessage('danger', 'Please enable atleast One Payment Gateway');
            return back();
        }

        if($request->payout_methods == '') {
            flashMessage('danger', 'Atleast One payout method should be enabled.');
            return back();
        }

        $this->validate($request, $rules, [], $attributes);

        $default_payments = array(
            payment_gateway('trip_default','Common'),
        );

        if($request->paypal_enabled == "0" && in_array('paypal',$default_payments)) {
            flashMessage('danger', 'Unable to Disable Paypal. Because this is default payment method');
            return back();
        }

        if($request->paytm_enabled == "0" && in_array('paytm',$default_payments)) {
            flashMessage('danger', 'Unable to Disable Paytm. Because this is default payment method');
            return back();
        }
        
        if($request->mpesa_enabled == "0" && in_array('mpesa',$default_payments)) {
            flashMessage('danger', 'Unable to Disable Mpesa. Because this is default payment method');
            return back();
        }
        
         if($request->mpesa_enabled == "0" && in_array('mollie',$default_payments)) {
            flashMessage('danger', 'Unable to Disable Mollie. Because this is default payment method');
            return back();
        }

        if($request->flutterwave_enabled == "0" && in_array('flutterwave',$default_payments)) {
            flashMessage('danger', 'Unable to Disable Flutterwave. Because this is default payment method');
            return back();
        }
        if(in_array('stripe',$default_payments))
        {
            if($request->stripe_enabled == "0" && $request->bt_enabled == "0") {
                flashMessage('danger', 'Please enable Stripe or Braintree. Because card is default payment method');
                return back();
            }
        }
        
        PaymentGateway::where(['name' => 'is_enabled', 'site' => 'Paypal'])->update(['value' => $request->paypal_enabled]);
        PaymentGateway::where(['name' => 'paypal_id', 'site' => 'Paypal'])->update(['value' => $request->paypal_id]);
        PaymentGateway::where(['name' => 'mode', 'site' => 'Paypal'])->update(['value' => $request->paypal_mode]);
        PaymentGateway::where(['name' => 'client', 'site' => 'Paypal'])->update(['value' => $request->paypal_client]);
        PaymentGateway::where(['name' => 'secret', 'site' => 'Paypal'])->update(['value' => $request->paypal_secret]);
        PaymentGateway::where(['name' => 'access_token', 'site' => 'Paypal'])->update(['value' => $request->paypal_access_token]);

        PaymentGateway::where(['name' => 'is_enabled', 'site' => 'Stripe'])->update(['value' => $request->stripe_enabled]);
        PaymentGateway::where(['name' => 'publish', 'site' => 'Stripe'])->update(['value' => $request->stripe_publish_key]);
        PaymentGateway::where(['name' => 'secret', 'site' => 'Stripe'])->update(['value' => $request->stripe_secret_key]);
        PaymentGateway::where(['name' => 'api_version', 'site' => 'Stripe'])->update(['value' => $request->stripe_api_version]);
        
        //Flutterwave
        
        PaymentGateway::where(['name' => 'is_enabled', 'site' => 'Flutterwave'])->update(['value' => $request->flutterwave_enabled]);
        PaymentGateway::where(['name' => 'mode', 'site' => 'Flutterwave'])->update(['value' => $request->flutterwave_mode]);
        PaymentGateway::where(['name' => 'public_key', 'site' => 'Flutterwave'])->update(['value' => $request->flutterwave_public_key]);
        PaymentGateway::where(['name' => 'secret_key', 'site' => 'Flutterwave'])->update(['value' => $request->flutterwave_secret_key]);
        PaymentGateway::where(['name' => 'encryption_key', 'site' => 'Flutterwave'])->update(['value' => $request->flutterwave_encryption_key]);
        
        //Mpesa
        
        PaymentGateway::where(['name' => 'is_enabled', 'site' => 'Mpesa'])->update(['value' => $request->mpesa_enabled]);
        PaymentGateway::where(['name' => 'mode', 'site' => 'Mpesa'])->update(['value' => $request->mpesa_mode]);
        PaymentGateway::where(['name' => 'consumer_key', 'site' => 'Mpesa'])->update(['value' => $request->consumer_key]);
        PaymentGateway::where(['name' => 'consumer_secret', 'site' => 'Mpesa'])->update(['value' => $request->consumer_secret]);
        PaymentGateway::where(['name' => 'callback_url', 'site' => 'Mpesa'])->update(['value' => $request->callback_url]);
        PaymentGateway::where(['name' => 'business_shortcode', 'site' => 'Mpesa'])->update(['value' => $request->business_shortcode]);

        //Paytm
        PaymentGateway::where(['name' => 'is_enabled', 'site' => 'Paytm'])->update(['value' => $request->paytm_enabled]);
        PaymentGateway::where(['name' => 'paytm_merchant', 'site' => 'Paytm'])->update(['value' => $request->paytm_merchant]);
        PaymentGateway::where(['name' => 'paytm_secret', 'site' => 'Paytm'])->update(['value' => $request->paytm_secret]);
        PaymentGateway::where(['name' => 'mode', 'site' => 'Paytm'])->update(['value' => $request->paytm_mode]);
        
        // Mollie
        PaymentGateway::where(['name' => 'is_enabled', 'site' => 'Mollie'])->update(['value' => $request->mollie_enabled]);
        PaymentGateway::where(['name' => 'api_key', 'site' => 'Mollie'])->update(['value' => $request->mollie_key]);
        PaymentGateway::where(['name' => 'partner_id', 'site' => 'Mollie'])->update(['value' => $request->mollie_partner]);
        PaymentGateway::where(['name' => 'profile_id', 'site' => 'Mollie'])->update(['value' => $request->mollie_profile]);
        PaymentGateway::where(['name' => 'mode', 'site' => 'Mollie'])->update(['value' => $request->mollie_mode]);
        

        PaymentGateway::where(['name' => 'is_enabled', 'site' => 'Braintree'])->update(['value' => $request->bt_enabled]);
        PaymentGateway::where(['name' => 'mode', 'site' => 'Braintree'])->update(['value' => $request->bt_mode]);
        PaymentGateway::where(['name' => 'merchant_id', 'site' => 'Braintree'])->update(['value' => $request->bt_merchant_id]);
        PaymentGateway::where(['name' => 'public_key', 'site' => 'Braintree'])->update(['value' => $request->bt_public_key]);
        PaymentGateway::where(['name' => 'private_key', 'site' => 'Braintree'])->update(['value' => $request->bt_private_key]);
        PaymentGateway::where(['name' => 'tokenization_key', 'site' => 'Braintree'])->update(['value' => $request->tokenization_key]);
        PaymentGateway::where(['name' => 'merchant_account_id', 'site' => 'Braintree'])->update(['value' => $request->merchant_account_id]);

        $payout_methods = implode(',',$request->payout_methods);

        PaymentGateway::where(['name' => 'payout_methods', 'site' => 'Common'])->update(['value' => $payout_methods]);
        PaymentGateway::where(['name' => 'is_web_payment', 'site' => 'Common'])->update(['value' => $request->is_web_payment]);

        /*if($request->stripe_enabled == "1" && !in_array('stripe',$default_payments)) {
            PaymentGateway::where(['name' => 'trip_default', 'site' => 'Common'])->update(['value' => 'stripe']);
        }

        if($request->bt_enabled == "1" && !in_array('braintree',$default_payments)) {
            PaymentGateway::where(['name' => 'trip_default', 'site' => 'Common'])->update(['value' => 'braintree']);
        }*/

        flashMessage('success', 'Updated Successfully');
    
        return redirect('admin/payment_gateway');
    }
}