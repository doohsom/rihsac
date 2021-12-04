<?php

namespace App\Services\Auth;

use App\Helpers\Twilio;
use App\Models\ActivityLog;
use App\Models\User;
use App\Traits\NotificationTrait;
use App\Models\ActivationToken;

class OnboardingService
{
    use NotificationTrait;
    public function confirmEmail($request, $id)
    {

        $user = User::person($id)->firstOrFail();
        try{
            $code = $request->code;
            $validCode = ActivationToken::email()->where(['email' => $user->email, 'code' => $code])->first();
            if($validCode) {
                $user->update(['email_verified' => true, 'onboarding_stage' => 'UPDATE_PROFILE']);
                $validCode->delete();
                ActivityLog::add('You verified your account', 'EMAIL_VERIFY', $user->id);
                return true;
            }
        }catch(\Throwable $th){
            report($th);
            return null;
        }
    }

    public function updateProfile($request, $id)
    {
        $user = User::person($id)->firstOrFail();
        if($user->email === null){
            return null;
        }

        try{
            $phone_number = $request->phone_number;
            $token = $this->generateVerificationCode();
            $user->update([
                'phone_number' => $request->phone_number,
                'state_id' => $request->state_id,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'onboarding_stage' => 'PHONE_VERIFY'
            ]);

            ActivityLog::add('You added your phone number, firstname, lastname, state','PHONE_NUMBER', $user->id);
            ActivationToken::add($phone_number, 'PHONE_TOKEN', $token);
            $this->sendSms($phone_number, $token);
            return true;

        } catch (\Throwable $th) {
            report($th);
            return null;
        }
    }

    public function confirmPhoneNumber($request, $id)
    {
        $user = User::person($id)->firstOrFail();
        if($user->phone_number === null){
            return null;
        }
        try{
            $code = $request->verification_code;
            $validCode = ActivationToken::sms()->where(['email' => $user->phone_number, 'code' => $code])->first();
            if($validCode){
                $user->update(['phone_verified' => true, 'onboarding_stage' => 'PRE_DASHBOARD']);
                $validCode->delete();

                ActivityLog::add('You confirmed your phone number', 'PHONE_VERIFY', $user->id);
                return true;
            }
        }catch (\Throwable $th) {
            report($th);
            return null;
        }
    }

}
