<?php

namespace App\Http\Requests\Profile;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEmploymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employment_status' => 'required|integer|exists:settings,id',
            'number_of_dependents' => 'required|integer',
            'monthly_income' => 'required|string',
            'monthly_savings' => 'required|string',
            'monthly_expense' => 'required|email|string'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'   => 'failure',
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
