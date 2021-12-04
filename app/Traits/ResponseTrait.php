<?php 

namespace App\Traits;

trait ResponseTrait{

    public function success($message, $status=200, $data = "")
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function failed($message, $status=400, $data = "")
    {
        return response()->json([
            'status' => 'failure',
            'message' => $message,
            'error' => $data
        ], $status);
    }

    public function validation($message, $status=422, $data = "")
    {
        return response()->json([
            'status' => 'failure',
            'message' => $message,
            'error' => $data
        ], $status);
    }
    
}