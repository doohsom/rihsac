<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Services\RegisterService;
use App\Traits\ResponseTrait;

class RegisterController extends Controller
{
    use ResponseTrait;

    public function register(StoreUserRequest $request, RegisterService $registerService)
    {
        $handle = $registerService->register($request);
        if($handle === null){
            return $this->failed('Unable to create account');
        }
        return $this->success('User account created successfully', 200,  $handle);
    }
}
