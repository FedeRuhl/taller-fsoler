<?php

namespace App\Http\Requests\Product;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'product_id' => 'exists:products,id|unique:products,id,' . $this->product_id,
            'depots' => 'array',
            'depots.*.id' => 'integer|exists:depots,id',
            'depots.*.stock' => 'integer',
            'depots.*.expiration_date' => 'date',
            'depots.*.lote_code' => 'string',
            'generic_id' => 'integer|exists:generics,id',
            'lab' => 'string'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['product_id' => $this->route('product_id')]);
    }
}