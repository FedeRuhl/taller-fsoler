<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'person' => new PersonResource($this->person),
            'unit' => new UnitResource($this->Unit),
            'os_number' => $this->os_number,
            'status' => $this->status,
            'is_military' => $this->is_military
        ];
    }
}
