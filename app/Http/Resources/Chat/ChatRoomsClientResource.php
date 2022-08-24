<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomsClientResource extends JsonResource
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
         * @var \App\Models\Room $this |self
         */
        return [
            'id'             => $this->id,
            'link'           => url('chat/' . $this->id),
            'messages_count' => $this->whenLoaded('messages', function () {
                return $this->messages->whereNotInStrict('administrator_id', null)->where('saw', false)->count();
            }),
            'last_message'   => $this->whenLoaded('messages', function () {
                if ($this->messages()->latest()->first()) {
                    return $this->messages()->latest()->first()->message;
                }
                return '';
            }),
            'first_name'     => $this->user->first_name,
            'last_name'      => $this->user->last_name,
            'email'          => $this->user->email,
        ];
    }
}
