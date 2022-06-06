<?php

namespace App\Http\Requests\Laboratory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLaboratoryRequest extends FormRequest
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
            'laboratory_id' => 'exists:laboratories,id|unique:laboratories,id,' . $this->laboratory_id,
            'name' => 'string'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['laboratory_id' => $this->route('laboratory_id')]);
    }
}