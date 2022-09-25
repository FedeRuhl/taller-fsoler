<?php

namespace App\Http\Requests\Supplier;

use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
            'supplier_id' => 'exists:suppliers,id|unique:suppliers,id,' . $this->supplier_id,
            'zip_code' => 'string',
            'street' => 'string',
            'number' => 'integer',
            'CUIT' => 'integer|unique:suppliers,CUIT,' . $this->supplier_id,
            'company_name' => 'string'
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['supplier_id' => $this->route('supplier_id')]);
    }
}