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
        return [
            'id' => $this->id,
            'SIByS_code' => $this->SIByS_code,
            'name' => $this->name,
            'is_disposable' => $this->is_disposable,
            'presentation' => $this->presentation
        ];
    }
}
