<?php

namespace App\Http\Requests\Phone;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class IndexPhoneRequest extends FormRequest
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
            'person_id' => 'required|integer|exists:people,id'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['person_id' => $this->route('person_id')]);
    }
}
