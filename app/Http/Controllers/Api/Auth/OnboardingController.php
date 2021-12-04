<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\OnboardingService;
use Illuminate\Http\Request;


class OnboardingController extends Controller
{
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function confirmEmailAddress(Request $request, OnboardingService $onboardingService)
    {
        $handle = $onboardingService->confirmEmail($request, $this->user->id);
        if($handle === null){
            return $this->failed('Unable to create account');
        }
        return $this->success('Email Verification Successful', 200);
    }

    public function updateProfile($request, OnboardingService $onboardingService)
    {
        $handle = $onboardingService->updateProfile($request,$this->user->id);
        if($handle === null){
            return $this->failed('Unable to update profile');
        }
        return $this->success('Profile update Successful', 200);
    }

    public function confirmPhoneNumber($request, OnboardingService $onboardingService)
    {
        $handle = $onboardingService->confirmPhoneNumber($request,$this->user->id);
        if($handle === null){
            return $this->failed('Unable to confirm phone number');
        }
        return $this->success('Phone Number Verification Successful', 200);
    }
}
