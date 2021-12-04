<?php

namespace App\Http\Requests\Profile;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank_id' => 'required|integer|exists:banks,id',
            'account_name' => 'required|string|max:100',
            'account_number' => 'required|integer!max:10',
            'bvn' => 'required|integer|max:11'
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
