<?php

namespace App\Http\Requests\Depot;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDepotRequest extends FormRequest
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
            'depot_id' => 'exists:depots,id|unique:depots,id,' . $this->depot_id,
            'name' => 'string'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['depot_id' => $this->route('depot_id')]);
    }
}