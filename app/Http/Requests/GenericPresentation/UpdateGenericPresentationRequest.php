<?php

namespace App\Http\Requests\GenericPresentation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGenericPresentationRequest extends FormRequest
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
            'generic_presentation_id' => 'exists:generic_presentations,id|unique:generic_presentations,id,' . $this->generic_presentation_id,
            'name' => 'string'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['generic_presentation_id' => $this->route('generic_presentation_id')]);
    }
}