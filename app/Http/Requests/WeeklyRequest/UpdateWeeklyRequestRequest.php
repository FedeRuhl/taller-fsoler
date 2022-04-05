<?php

namespace App\Http\Requests\WeeklyRequest;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWeeklyRequestRequest extends FormRequest
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
            'request_id' => 'exists:weekly_requests,id|unique:weekly_requests,id,' . $this->request_id,
            'owner_id' => 'exists:users,id|unique:users,id,' . $this->owner_id,
            'service_id' => 'exists:services,id|unique:services,id,' . $this->service_id,
            'date' => 'date',
            'is_authorized' => 'boolean',
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['request_id' => $this->route('request_id')]);
    }
}