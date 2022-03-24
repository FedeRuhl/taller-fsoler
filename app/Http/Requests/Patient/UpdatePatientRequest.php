<?php

namespace App\Http\Requests\Patient;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
            'patient_id' => 'exists:patients,id|unique:patients,id,' . $this->patient_id,
            'dni' => 'integer',
            'first_name' => 'string',
            'last_name' => 'string',
            'birth_date' => 'date',
            'os_number' => 'string',
            'status' => 'nullable|string',
            'is_military' => 'boolean',
            'unit_id' => 'required_if:is_military,1|integer|exists:units,id'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['patient_id' => $this->route('patient_id')]);
    }
}