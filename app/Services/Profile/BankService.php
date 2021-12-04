<?php

namespace App\Services\Profile;

use JWTAuth;
use Illuminate\Support\Facades\App;
use App\Models\ActivityLog;
use App\Models\BankInformation;
use Ramsey\Uuid\Uuid;


class BankService
{

    public function __construct()
    {
        if(App::environment('local')){
            $this->config = 'cashir.staging';
        }else{
            $this->config = config('cashir.production');
        }

    }
    public function store($request, $id)
    {
        try {
            BankInformation::updateOrCreate(
                ['user_id' => $id, 'uuid' => Uuid::uuid4()->toString()],
                ['bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'bvn' => $request->bvn
                ]
            );

            ActivityLog::add(' updated  bank information','LOG', $id);
                return true;
        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }

    public function read($id)
    {
        try{
            $bank = BankInformation::where('user_id', $id)->first();
            return $bank;
        }catch (\Throwable $th) {
            report($th);
            return null;
        }
    }

}
