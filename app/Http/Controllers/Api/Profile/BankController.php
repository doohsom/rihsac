<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\StoreBankRequest;
use App\Services\Profile\BankService;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function store(StoreBankRequest $request, BankService $bankService)
    {
        $handle = $bankService->store($request, $this->user->id);
        if($handle === null){
            return $this->failed('Unable to update bank information.');
        }
        return $this->success('Bank information update successful', 200);
    }

    public function read(BankService $bankService)
    {
        $handle = $bankService->read($this->user->id);
        if($handle === null){
            return $this->failed('Unable to get bank information.');
        }
        return $this->success('Bank information retrieved successful', 200);
    }
}
