<?php

namespace App\Http\Requests\Unit;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
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
            'unit_id' => 'exists:units,id|unique:units,id,' . $this->unit_id,
            'city' => 'string',
            'province' => 'string',
            'zip_code' => 'string',
            'name' => 'string|unique:units,name,' . $this->unit_id
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['unit_id' => $this->route('unit_id')]);
    }
}