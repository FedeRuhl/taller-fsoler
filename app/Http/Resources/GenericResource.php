<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GenericResource extends JsonResource
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
            'SIByS_code' => $this->SIByS_code,
            'name' => $this->name,
            'is_disposable' => $this->is_disposable,
            'presentations' => GenericPresentationResource::collection($this->presentations)
        ];

        if (isset($this->pivot->generics_total_quantity))
            $data['total_quantity'] = $this->pivot->generics_total_quantity;

        if (isset($this->pivot->generics_consumed_quantity))
            $data['consumed_quantity'] = $this->pivot->generics_consumed_quantity;

        return $data;
    }
}
