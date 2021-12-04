<?php

namespace App\Traits;

use App\Mail\MailNotification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

trait NotificationTrait{

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

    public function sendEmail($user, $code, $subject, $view)
    {
        $details = [
            'firstname' =>  $user->firstname,
            'email' => $user->email,
            'token' => $code,
            'view' => $view,
            'subject' => $subject,
            'url' => $this->config
        ];
        dispatch(function() use ($details){
            Mail::to($details['email'])->send(new MailNotification($details));
        })->afterResponse();
    }

    public function sendSms($phone, $message) : void
    {
        $token = config($this->TWILIO_AUTH_TOKEN);
        $twilio_sid = config($this->TWILIO_SID);
        $twilio_number = config($this->TWILIO_NUMBER);
        $twilio = new Client($twilio_sid, $token);

        $twilio->messages->create($phone, [
            'from' => $twilio_number,
            'body' => $message
        ]);
    }

    public function generateVerificationCode()
    {
        return rand(100000,999999);
    }
}
