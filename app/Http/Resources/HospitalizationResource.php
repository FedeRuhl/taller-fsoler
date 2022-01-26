<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HospitalizationResource extends JsonResource
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
            'patient' => new PatientResource($this->Patient),
            'service' => new ServiceResource($this->Service),
            'is_ambulatory' => $this->is_ambulatory,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ];
    }
}
