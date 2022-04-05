<?php

namespace App\Http\Requests\WeeklyRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreWeeklyRequestRequest extends FormRequest
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
            'service_id' => 'required|integer|exists:services,id',
            'date' => 'required|date',
            'is_authorized' => 'required|boolean'
        ];
    }
}
