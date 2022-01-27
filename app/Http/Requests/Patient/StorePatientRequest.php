<?php

namespace App\Http\Requests\Patient;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'person_id' => 'required|integer|exists:people,id',
            'unit_id' => 'required|integer|exists:units,id',
            'os_number' => 'required|string',
            'status' => 'nullable|string',
            'is_military' => 'required|boolean'
        ];
    }
}
