<?php

namespace App\Http\Requests\Hospitalization;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHospitalizationRequest extends FormRequest
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
            'hospitalization_id' => 'exists:hospitalizations,id|unique:hospitalizations,id,' . $this->hospitalization_id,
            'patient_id' => 'integer|exists:patients,id',
            'service_id' => 'integer|exists:services,id',
            'is_ambulatory' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['hospitalization_id' => $this->route('hospitalization_id')]);
    }
}