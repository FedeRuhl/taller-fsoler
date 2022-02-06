<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'depots' => 'required|array',
            'depots.*.id' => 'required|integer|exists:depots,id',
            'depots.*.stock' => 'required|integer',
            'depots.*.expiration_date' => 'date',
            'depots.*.lote_code' => 'string',
            'generic_id' => 'required|integer|exists:generics,id',
            'lab' => 'required|string'
        ];
    }
}
