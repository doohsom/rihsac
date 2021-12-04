<?php

namespace App\Services\Profile;

use App\Models\ActivityLog;
use App\Models\DocumentUpload;
use App\Models\User;
use App\Traits\NotificationTrait;
use App\Models\ActivationToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class ProfileService
{
    use NotificationTrait;

    public function resendEmailWithCode($user)
    {
        $time = ActivationToken::email()->where(['email' => $user->email])->latest();
        $now = Carbon::now();
        $time_ago = $time->diffInMinutes($now);
        if($time_ago < 1) {
            return null;
        }
        try{
            $code = $this->generateVerificationCode();
            ActivityLog::add(' resent email code','EMAIL_CODE', $user->id);
            ActivationToken::add($user->email, 'EMAIL_TOKEN', $code);
            $this->sendEmail($user, $code, 'Please verify your email address', 'mails.verify-email');
            return true;
        } catch (\Throwable $th) {
            report($th);
            return null;
        }
    }

    public function resendSMSWithCode($user)
    {
        $time = ActivationToken::sms()->where(['email' => $user->email])->latest();
        $now = Carbon::now();
        $time_ago = $time->diffInMinutes($now);
        if($time_ago < 1) {
            return null;
        }
        try{
            $code = $this->generateVerificationCode();
            ActivityLog::add(' resent sms code','PHONE_NUMBER', $user->id);
            ActivationToken::add($user->email, 'PHONE_TOKEN', $code);
            return true;
        }catch (\Throwable $th) {
            report($th);
            return null;
        }

    }

    public function updateUserName($request, $id)
    {
        $user = User::person($id)->firstOrFail();
        if($user->phone_number === null || $user->email === null){
            return null;
        }
        try{
            $user->update(['username' => $request->username]);
            ActivityLog::add('updated username','USERNAME', $user->id);
            return true;
        }catch (\Throwable $th) {
            report($th);
            return null;
        }
    }

    public function updateProfilePicture($request, $id)
    {
        $user = User::person($id)->firstOrFail();
        if($user->phone_number === null || $user->email === null){
            return null;
        }
        try{
            $path = $request->file('avatar')->store('avatars');
            $image = Image::make(public_path("storage/{$path}"))->fit(150, 150);
            $image->save();

            $user->update(['avatar' => $path]);
            ActivityLog::add('updated avatar','AVATAR', $user->id);
            return true;
        }catch (\Throwable $th) {
            report($th);
            return null;
        }
    }

    public function uploadDocument($request, $id)
    {
        $user = User::person($id)->firstOrFail();
        if($user->phone_number === null || $user->email === null){
            return null;
        }
        $document = DocumentUpload::where(
                                    ['user_id' => $id, 'upload_type' => $request->upload_type]
                    )->first();

        try{

            if($document){
                $path = $document->document_path;
            }else{
                $path = $request->file('document')->store('document');
                $path->save();
            }

            DocumentUpload::updateOrCreate(
                ['user_id' => $this->user->id, 'upload_type' => $request->upload_type],
                ['id_card_type' => $request->id_card_type,
                 'document_name' => $request->document_name,
                 'document_path' => $path
                ]
            );
            ActivityLog::add(' updated your document','DOCUMENT', $this->user->id);
            return true;
        }catch (\Throwable $th) {
            report($th);
            return null;
        }
    }

    public function updateTransactionPin($request, $id)
    {
        $user = User::person($id)->firstOrFail();
        if($user->phone_number === null || $user->email === null){
            return null;
        }
        try{
            $user->update(['transaction_pin' => $request->trasnaction_pin]);
            ActivityLog::add('updated trasnaction pin','PIN', $user->id);
            return true;
        }catch (\Throwable $th) {
            report($th);
            return null;
        }
    }

}
