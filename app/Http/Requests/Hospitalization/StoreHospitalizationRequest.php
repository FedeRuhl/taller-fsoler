<?php

namespace App\Http\Requests\Hospitalization;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreHospitalizationRequest extends FormRequest
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
            'patient_id' => 'required|integer|exists:patients,id',
            'service_id' => 'required|integer|exists:services,id',
            'is_ambulatory' => 'required|boolean',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }
}
