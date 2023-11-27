<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Mail;
use URL;
use Auth;
use Session;
use Config;
use DateTime;
use DateTimeZone;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use App\Models\PasswordResets;
use App\Models\Country;
use App\Models\Currency;
use App\Mail\MailQueue;

class EmailController extends Controller
{
    
     /**
     * Send Forgot Password Mail with Confirmation Link
     *
     * @param array $user  User Details
     * @return true
     */
    public function forgot_password_link($user)
    {
        $data['first_name'] = $user->first_name;

        $token = $data['token'] = str_random(100); // Generate random string values - limit 100
        $url = $data['url'] = URL::to('/').'/';

        $data['locale']       = App::getLocale();

        $password_resets = new PasswordResets;

        $password_resets->email      = $user->email;
        $password_resets->token      = $data['token'];
        $password_resets->created_at = date('Y-m-d H:i:s');
        
        $password_resets->save(); // Insert a generated token and email in password_resets table
        logger("testingg llogger");
        $email      = $user->email;
        $content    = [
            'first_name' => $user->first_name, 
            'url'=> $url,
            'token' => $token
            ];
        // Send Forgot password email to give user email
        try {
            Mail::to($email)->queue(new ForgotPasswordMail($content));
            return true;
            // $jsonString = file_get_contents($destinationPath);          
        }
        catch (\Exception $e) {
            return false ;
            // $jsonString = "";   
        }
    }

    /**
     * Send Forgot Password Mail with Confirmation Link
     *
     * @param array $company  Company Details
     * @return true
     */
    public function company_forgot_password_link($company)
    {
        $data['first_name'] = $company->name;

        $token = $data['token'] = str_random(100); // Generate random string values - limit 100
        $url = $data['url'] = URL::to('/').'/company/';

        $data['locale']       = App::getLocale();

        $password_resets = new PasswordResets;

        $password_resets->email      = $company->email;
        $password_resets->token      = $data['token'];
        $password_resets->created_at = date('Y-m-d H:i:s');
        
        $password_resets->save(); // Insert a generated token and email in password_resets table
        $email      = $company->email;
        $content    = [
            'first_name' => $company->name, 
            'url'=> $url,
            'token' => $token
            ];

        // Send Forgot password email to give user email
        try {
            Mail::to($email)->queue(new ForgotPasswordMail($content));
            return true;
            // $jsonString = file_get_contents($destinationPath);          
        }
        catch (\Exception $e) {
            return false ;
            // $jsonString = "";   
        }

    }
   
        /**
     * send mail to sales
     *
     * @param array $data eamil Details
     * @return true
     */
    public function pop_up_email()
    {
        Session::put('pop_email', 'yes');
        $data['data']       = request()->all();
        $data['url']        = url('/').'/';
        $data['locale']     = App::getLocale(); 
        $data['subject']    = 'Let\'s talk about gojek clone - product';
        $data['email']      = 'cloneappsolutions@gmail.com';
        $data['name']       = 'sales';
        

        $data['view_file'] = 'emails.pop_email';
        Mail::to($data['email'],$data['name'])->queue(new MailQueue($data));

        return array('success'=>'true');
    }
}
