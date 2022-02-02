<?php

namespace App\Http\Requests\User;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'user_id' => 'exists:users,id|unique:users,id,' . $this->user_id,
            'dni' => 'integer',
            'first_name' => 'string',
            'last_name' => 'string',
            'birth_date' => 'date',
            'docket' => 'numeric',
            'email' => 'email',
            'password' => 'string',
            'user_class_id' => 'integer|exists:user_classes,id'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['user_id' => $this->route('user_id')]);
    }
}