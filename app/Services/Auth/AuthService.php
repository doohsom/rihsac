<?php

namespace App\Services\Auth;

use App\Models\ActivityLog;
use App\Models\User;
use App\Traits\ResponseTrait;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService
{
    use ResponseTrait;

    public function login($request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return null;
            }
            ActivityLog::add(' created an account','LOGIN', auth()->user()->id);
            return $token;
        } catch (JWTException $e) {
            return null;
        }

    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'role' => auth()->user()->role,
            'onboarding_stage' => auth()->user()->onboarding_stage,
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function logout() {
        auth()->logout();

        return $this->success("User successfully signed out", 200, null);
    }
}
