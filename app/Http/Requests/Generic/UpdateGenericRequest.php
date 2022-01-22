<?php

namespace App\Http\Requests\Generic;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGenericRequest extends FormRequest
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
            'generic_id' => 'exists:generics,id|unique:generics,id,' . $this->generic_id,
            'SIByS_code' => 'integer',
            'name' => 'string',
            'is_disposable' => 'boolean',
            'presentation' => 'string'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['generic_id' => $this->route('generic_id')]);
    }
}