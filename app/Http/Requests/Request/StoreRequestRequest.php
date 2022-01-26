<?php

namespace App\Http\Requests\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
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
            'owner_id' => 'required|integer|exists:users,id',
            'hospitalization_id' => 'required|integer|exists:hospitalizations,id',
            'date' => 'required|date',
            'is_authorized' => 'required|boolean'
        ];
    }
}
