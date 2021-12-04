<?php

namespace App\Http\Requests\Profile;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDocumentUploadRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'document_path' => 'file|max:512',
            'document_name' => 'required|integer|exists:settings,id',
            'upload_type' => 'required|integer',
            'id_card_type' => 'required|string'
        ];
    }

    /**
     * Returns the validation response to the controler
     *
     * @return json
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'   => 'failure',
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
