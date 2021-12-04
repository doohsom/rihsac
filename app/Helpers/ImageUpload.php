<?php

namespace App\Helpers;

class ImageUpload{

    public function upload($request)
    {
        if($file = $request->file('file')){
            $path = $file->store('public/files');
            return $path;
        }
        return false;
    }
}

