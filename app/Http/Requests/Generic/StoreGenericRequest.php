<?php

namespace App\Http\Requests\Generic;

use Illuminate\Foundation\Http\FormRequest;

class StoreGenericRequest extends FormRequest
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
            'SIByS_code' => 'required|string|unique:generics',
            'name' => 'required|string',
            'is_disposable' => 'boolean',
            'presentation_ids' => 'required|array|min:1'
        ];
    }
}
