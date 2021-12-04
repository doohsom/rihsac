<?php

namespace App\Services\Profile;

use App\Models\EmploymentInformation;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\App;
use App\Models\ActivityLog;
use App\Traits\ResponseTrait;
use Ramsey\Uuid\Uuid;


class EmploymentService
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
            $upSave = EmploymentInformation::updateOrCreate(
                ['user_id' => $this->user->id, 'uuid' => Uuid::uuid4()->toString()],
                ['employment_status' => $request->employment_status,
                'number_of_dependents' => $request->number_of_dependents,
                'monthly_income' => $request->monthly_income,
                'monthly_savings' => $request->monthly_savings,
                'monthly_expense' => $request->monthly_expense
                ]
            );
            if($upSave){
                ActivityLog::add('You updated your employment information','LOG', $this->user->id);
                return $this->success('Employment Information saved successfully');
            }
        } catch (\Throwable $th) {
            report($th);
            return $this->failed('Unable to save Employment Information');
        }
    }

    public function read($id)
    {
        try{
            $guarantor = EmploymentInformation::where('user_id', $id)->with('relationship')->first();
            return $this->success('guarantor Information saved successfully', $guarantor);
        }catch (\Throwable $th) {
            report($th);
            return $this->failed('Unable to fetch Guarantor Information');
        }
    }

}
