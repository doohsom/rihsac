<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Profile\StoreDocumentRequest;
use App\Helpers\ImageUpload;
use JWTAuth;

class DocumentUploadController extends Controller
{
    public function __construct()
    {    
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function store(StoreDocumentRequest $request)
    {
        $upload = new ImageUpload();
        $path = $upload->upload($request);
        if($path === false){
            return false;
        }
        $data = [
            
        ]
        return $guarantorService->store($request, $this->user->id);
    }

    public function read(GuarantorService $guarantorService)
    {
        return $guarantorService->read($this->user->id);
    }
}
