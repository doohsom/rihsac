<?php
    
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Twilio\Rest\Client;
use Exception;

class Twilio{
    public function __construct()
    {
        if(App::environment('local')){
            $this->config = 'cashir.staging';
        }else{
            $this->config = config('cashir.production');
        }
        $this->TWILIO_SID = $this->config.'.'.'TWILIO_SID';
        $this->TWILIO_AUTH_TOKEN = $this->config.'.'.'TWILIO_AUTH_TOKEN';
        $this->TWILIO_NUMBER = $this->config.'.'.'TWILIO_NUMBER';
    }

    public function sendSMS($data)
    {
        try{
            $token = config($this->TWILIO_AUTH_TOKEN);
            $twilio_sid = config($this->TWILIO_SID);
            $twilio_number = config($this->TWILIO_NUMBER);
            $twilio = new Client($twilio_sid, $token);
           
            $twilio->messages->create($data['phone'], [
                'from' => $twilio_number, 
                'body' => $data['message']]);
        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }
    }

    public function verifyPhoneNumber($verification_code, $phone_number)
    {
        try{
            $token = config($this->TWILIO_AUTH_TOKEN);
            $twilio_sid = config($this->TWILIO_SID);
            $twilio_verify_sid = config($this->TWILIO_VERIFY_SID);
            $twilio = new Client($twilio_sid, $token);
            $verification = $twilio->verify->v2->services($twilio_verify_sid)
                                                ->verificationChecks
                                                ->create($verification_code, array('to' => $phone_number));
            return $verification;
        }catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }
    }
}

