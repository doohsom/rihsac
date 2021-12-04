<?php

namespace App\Services\Auth;

use App\Helpers\Twilio;
use App\Models\ActivityLog;
use App\Models\User;
use App\Traits\NotificationTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotification;
use App\Models\ActivationToken;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Integer;
use Ramsey\Uuid\Uuid;


class RegisterService
{
    use NotificationTrait;


    public function register($request, AuthService $authService)
    {
        try {
            $data = [
                'uuid' => Uuid::uuid4()->toString(),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'onboarding_stage' => 'EMAIL_VERIFY',
                'role' => 'USER',
                'cashir_id' => $this->generateCashirId(),
                'status' => 'enabled'
            ];
            $user = User::create($data);
            $verificationCode = $this->generateVerificationCode();
            if($user){
                ActivityLog::add(' created an account','REGISTER', $user->id);
                ActivationToken::add($user->email, 'EMAIL_TOKEN', $verificationCode);
                $login = $authService->login($request);
                $this->sendEmail($user, $verificationCode, 'Please verify your email address','mails.verify-email');

                return $login;
            }
        } catch (\Throwable $th) {
            report($th);
            return null;
        }
    }

    private function generateCashirId() : Integer
    {
        return rand(1000000000,9999999999);
    }

}
