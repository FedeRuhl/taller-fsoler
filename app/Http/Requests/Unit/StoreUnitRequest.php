<?php

namespace App\Http\Requests\Unit;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
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
            'city_id' => 'required|exists:cities,id|unique:cities,id,' . $this->city_id,
            'province_id' => 'required|exists:provinces,id|unique:provinces,id,' . $this->province_id,
            'zip_code' => 'required|string',
            'name' => 'required|string|unique:units'
        ];
    }
}
