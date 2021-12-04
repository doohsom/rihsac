<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\StoreEmploymentRequest;
use App\Services\Profile\EmploymentService;
use Illuminate\Http\Request;

class EmploymentController extends Controller
{
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function store(StoreEmploymentRequest $request, EmploymentService $employmentService)
    {
        $handle = $employmentService->store($request, $this->user->id);
        if($handle === null){
            return $this->failed('Unable to update employment information.');
        }
        return $this->success('Employment information update successful', 200);
    }

    public function read(EmploymentService $employmentService)
    {
        $handle = $employmentService->read($this->user->id);
        if($handle === null){
            return $this->failed('Unable to get employment information.');
        }
        return $this->success('Employment information retrieved successful', 200);
    }
}
