<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\StoreResidentialRequest;
use App\Services\Profile\ResidentialService;
use Illuminate\Http\Request;

class ResidentialController extends Controller
{
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function store(StoreResidentialRequest $request, ResidentialService $residentialService)
    {
        $handle = $residentialService->store($request, $this->user->id);
        if($handle === null){
            return $this->failed('Unable to update residential information.');
        }
        return $this->success('Residential information update successful', 200);
    }

    public function read(ResidentialService $residentialService)
    {
        $handle = $residentialService->read($this->user->id);
        if($handle === null){
            return $this->failed('Unable to get residential information.');
        }
        return $this->success('Residential information retrieved successful', 200);
    }
}
