<?php

namespace App\Http\Requests\Depot;

use Illuminate\Foundation\Http\FormRequest;

class ModifyDepotProductRequest extends FormRequest
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
            'product_id' => 'exists:products,id|unique:products,id,' . $this->product_id,
            'stock' => 'required|integer',
            'expiration_date' => 'required|date',
            'lote_code' => 'required|string'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['depot_id' => $this->route('depot_id')]);
        $this->merge(['product_id' => $this->route('product_id')]);
    }
}