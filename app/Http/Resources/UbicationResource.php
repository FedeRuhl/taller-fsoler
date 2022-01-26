<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UbicationResource extends JsonResource
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
            'city' => $this->city,
            'province' => $this->province,
            'zip_code' => $this->zip_code,
        ];
    }
}
