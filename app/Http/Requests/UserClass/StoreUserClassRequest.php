<?php

namespace App\Http\Requests\UserClass;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserClassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO: solo el admin puede crear más "roles"
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
            'name' => 'required|string'
        ];
    }
}
