<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'onwer' => new UserResource($this->Owner),
            'supplier' => new SupplierResource($this->Supplier),
            'order_type' => new OrderTypeResource($this->OrderType),
            'number' => $this->number,
            'date' => $this->date
        ];
    }
}
