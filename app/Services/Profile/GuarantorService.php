<?php

namespace App\Services\Profile;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\App;
use App\Models\ActivityLog;
use App\Models\GuarantorInformation;
use App\Traits\ResponseTrait;
use Ramsey\Uuid\Uuid;


class GuarantorService
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
            $upSave = GuarantorInformation::updateOrCreate(
                ['user_id' => $this->user->id, 'uuid' => Uuid::uuid4()->toString()],
                ['firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'relationship_id' => $request->relationship_id
                ]
            );
            if($upSave){
                ActivityLog::add('You updated your guarantor information','LOG', $this->user->id);
                return $this->success('Guarantor Information saved successfully');
            }
        } catch (\Throwable $th) {
            report($th);
            return $this->failed('Unable to save Guarantor Information');
        }
    }

    public function read($id)
    {
        try{
            $guarantor = GuarantorInformation::where('user_id', $id)->with('relationship')->first();
            return $this->success('Guarantor Information retrieved successfully', 200, $guarantor);
        }catch (\Throwable $th) {
            report($th);
            return $this->failed('Unable to fetch Guarantor Information');
        }
    }

}
