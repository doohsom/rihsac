<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Requests\Profile\GuarantorFormRequest;
use App\Services\Profile\GuarantorService;

class GuarantorController extends Controller
{
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function store(GuarantorFormRequest $request, GuarantorService $guarantorService)
    {
        $handle = $guarantorService->store($request, $this->user->id);
        if($handle === null){
            return $this->failed('Unable to update guarantor information.');
        }
        return $this->success('Guarantor information update successful', 200);
    }

    public function read(GuarantorService $guarantorService)
    {
        $handle = $guarantorService->read($this->user->id);
        if($handle === null){
            return $this->failed('Unable to get guarantor information.');
        }
        return $this->success('Guarantor information retrieved successful', 200);
    }
}
