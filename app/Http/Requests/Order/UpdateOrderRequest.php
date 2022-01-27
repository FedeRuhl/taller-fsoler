<?php

namespace App\Http\Requests\Order;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'order_id' => 'exists:orders,id|unique:orders,id,' . $this->order_id,
            'owner_id' => 'integer|exists:users,id',
            'supplier_id' => 'integer|exists:suppliers,id',
            'order_type_id' => 'integer|exists:order_types,id',
            'number' => 'string',
            'date' => 'date'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['order_id' => $this->route('order_id')]);
    }
}