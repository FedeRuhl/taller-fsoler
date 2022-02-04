<?php

namespace App\Http\Requests\Phone;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePhoneRequest extends FormRequest
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
            'phone_id' => 'exists:phones,id|unique:phones,id,' . $this->phone_id,
            'person_id' => 'prohibited',
            'number' => 'numeric'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['phone_id' => $this->route('phone_id')]);
    }
}