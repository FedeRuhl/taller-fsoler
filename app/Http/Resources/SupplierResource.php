<?php

namespace App\Http\Resources;

use App\Models\SupplierAddress;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'address' => new SupplierAddressResource($this->address),
            'CUIT' => $this->CUIT,
            'company_name' => $this->company_name
        ];
    }
}
