<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\StoreDocumentUploadRequest;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Profile\ProfileService;

use Illuminate\Support\Facades\Validator;
use JWTAuth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function resendEmailWithCode(ProfileService $profileService)
    {
        $handle = $profileService->resendEmailWithCode($this->user);
        if($handle === null){
            return $this->failed('Unable to send email. Please try again!');
        }
        return $this->success('Email sent Successful', 200);
    }

    public function resendSMSWithCode(ProfileService $profileService)
    {
        $handle = $profileService->resendSMSWithCode($this->user);
        if($handle === null){
            return $this->failed('Unable to send sms. Please try again!');
        }
        return $this->success('SMS sent Successful', 200);
    }

    public function createUsername(Request $request, ProfileService $profileService)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:30|unique:users,username',
        ]);
        if($validator->fails()){
            return $this->validation("Username exists", 422, $validator->errors());
        }else{
            $handle = $profileService->updateUserName($request, $this->user->id);
            if($handle === null){
                return $this->failed('Unable to update username.');
            }
            return $this->success('Username update successful', 200);
        }
    }

    public function uploadProfilePicture(Request $request, ProfileService $profileService)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);
        if($validator->fails()){
            return $this->validation("Invalid file", 422, $validator->errors());
        }else {
            $handle = $profileService->updateProfilePicture($request, $this->user->id);
            if ($handle === null) {
                return $this->failed('Unable to update avatar. Please try again!');
            }
            return $this->success('Avatar upload successful', 200);
        }
    }

    public function uploadDocument(StoreDocumentUploadRequest $request, ProfileService $profileService)
    {
        $handle = $profileService->uploadDocument($request, $this->user->id);
        if($handle === null){
            return $this->failed('Unable to upload document. Please try again!');
        }
        return $this->success('Document upload successful', 200);
    }


    public function createTransactionPIN(Request $request, ProfileService $profileService)
    {
        $validator = Validator::make($request->all(), [
            'transaction_pin' => ['required', 'confirmed', Password::max(4)],
        ]);
        if($validator->fails()){
            return $this->validation("Invalid password format", 422, $validator->errors());
        }else{
            $handle = $profileService->updateTransactionPin($request, $this->user->id);
            if($handle === null){
                return $this->failed('Unable to update transaction pin');
            }
            return $this->success('Transaction pin updated successfully', 200);
        }
    }

}
