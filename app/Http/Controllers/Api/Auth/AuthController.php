<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Models\ActivityLog;
use App\Traits\ResponseTrait;
use App\Auth\Services\AuthService;

class AuthController extends Controller
{
    use ResponseTrait;

    public function login(Request $request, AuthService $auth)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return $this->validation("Validation Errors", 422, $validator->errors());
        }else{
            $handle = $auth->login($request);
            if($handle === null){
                return $this->failed('Unable to verify email account');
            }
            return $this->success("success", 200, $handle);
        }
    }

    public function logout()
    {
        auth()->logout();
        ActivityLog::add('You logged out','LOGOUT', auth()->user()->id);
        return response()->json(['message' => 'User successfully signed out']);
    }
}
