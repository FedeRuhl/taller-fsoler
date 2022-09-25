<?php

namespace App\Http\Requests\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ConsumeRequestRequest extends FormRequest
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
            'generics' => 'required|array|min:1',
            'generics.*.id' => 'required|integer|exists:generics,id',
            'generics.*.products' => 'required|array|min:1',
            'generics.*.products.*.id' => 'required|integer|exists:products,id',
            'generics.*.products.*.consumed_quantity' => 'required|integer',
        ];
    }
}
