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
            'owner' => new UserResource($this->owner),
            'supplier' => new SupplierResource($this->supplier),
            'order_type' => new OrderTypeResource($this->orderType),
            'number' => $this->number,
            'date' => $this->date,
            'products' => ProductResource::collection($this->products),
        ];
    }
}
