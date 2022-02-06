<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepotResource extends JsonResource
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
            'name' => $this->name
        ];

        if (isset($this->pivot->stock))
            $data['product_stock'] = $this->pivot->stock;

        if (isset($this->pivot->expiration_date))
            $data['product_expiration_date'] = $this->pivot->expiration_date;

        if (isset($this->pivot->lote_code))
            $data['product_lote_code'] = $this->pivot->lote_code;

        return $data;
    }
}
