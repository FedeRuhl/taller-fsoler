<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            'owner' => new UserResource($this->Owner),
            'hospitalization' => new HospitalizationResource($this->Hospitalization),
            'date' => $this->date,
            'is_authorized' => $this->is_authorized
        ];
    }
}
