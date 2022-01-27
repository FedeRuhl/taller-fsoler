<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'order_type_id' => 'required|integer|exists:order_types,id',
            'number' => 'required|string',
            'date' => 'date'
        ];
    }
}
