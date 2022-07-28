<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;

class MessagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var \App\Models\Message $this
         */
        return [
            'id'               => $this->id,
            'administrator' => MessageAdminnistratorResource::make($this->whenLoaded('administrator')),
            'user' => MessageUserResource::make($this->whenLoaded('user')),
            'message'          => $this->message,
            'created_at'       => $this->created_at,
            'saw'              => $this->saw,

        ];
    }
}
