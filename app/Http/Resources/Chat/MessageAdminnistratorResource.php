<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageAdminnistratorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var \App\Models\Administrator $this
         */
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
