<?php

namespace App\Services\Profile;

use App\Models\ResidentialInformation;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\App;
use App\Models\ActivityLog;
use App\Traits\ResponseTrait;
use Ramsey\Uuid\Uuid;


class ResidentialService
{
    use ResponseTrait;

    public function __construct()
    {
        if(App::environment('local')){
            $this->config = 'cashir.staging';
        }else{
            $this->config = config('cashir.production');
        }

    }

    public function store(Request $request)
    {
        try {
            $upSave = ResidentialInformation::updateOrCreate(
                ['user_id' => $this->user->id, 'uuid' => Uuid::uuid4()->toString()],
                ['apartment_type' => $request->apartment_type,
                'ownership' => $request->ownership
                ]
            );
            if($upSave){
                ActivityLog::add('You updated your residential information','LOG', $this->user->id);
                return $this->success('Residential Information saved successfully');
            }
        } catch (\Throwable $th) {
            report($th);
            return $this->failed('Unable to save Residential Information');
        }
    }

    public function read($id)
    {
        try{
            $residential = ResidentialInformation::where('user_id', $id)->with('apartment_type','ownership')->first();
            return $this->success('Residential Information saved successfully', $residential);
        }catch (\Throwable $th) {
            report($th);
            return $this->failed('Unable to fetch Residential Information');
        }
    }

}
