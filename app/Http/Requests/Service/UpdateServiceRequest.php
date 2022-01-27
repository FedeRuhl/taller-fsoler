<?php

namespace App\Http\Requests\Service;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'service_id' => 'exists:services,id|unique:services,id,' . $this->service_id,
            'name' => 'string'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['service_id' => $this->route('service_id')]);
    }
}