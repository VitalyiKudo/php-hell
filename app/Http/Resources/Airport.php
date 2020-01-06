<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Airport extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'country' => new Country($this->whenLoaded('country')),
            'iata' => $this->iata,
            'icao' => $this->icao,
            'latitude' => (float) $this->latitude,
            'longitude' => (float) $this->longitude,
            'altitude' => $this->altitude,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
