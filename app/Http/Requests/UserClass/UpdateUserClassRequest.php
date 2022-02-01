<?php

namespace App\Http\Requests\UserClass;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserClassRequest extends FormRequest
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
            'user_class_id' => 'exists:user_classes,id|unique:user_classes,id,' . $this->user_class_id,
            'name' => 'string'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['user_class_id' => $this->route('user_class_id')]);
    }
}