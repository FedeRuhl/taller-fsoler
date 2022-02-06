<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'generic' => new GenericResource($this->generic),
            'lab' => $this->lab,
            'depots' => DepotResource::collection($this->depots)
        ];

        if (isset($this->pivot->product_quantity))
            $data['quantity'] = $this->pivot->product_quantity;

        return $data;
    }
}
