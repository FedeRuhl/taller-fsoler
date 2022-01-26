<?php

namespace App\Http\Requests\Product;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;

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
            'generic_id' => 'integer|exists:generics,id',
            'lab' => 'string'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['product_id' => $this->route('product_id')]);
    }
}