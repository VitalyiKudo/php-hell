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
            'id'    => $this->getAttribute('id'),
            'link'  => url('chat/' . $this->id),
            'title' => $this->whenLoaded('user', function () {
                return $this->user->first_name . " " . $this->user->last_name . " " . $this->user->email . $this->whenLoaded('messages', function (
                    ) {
                        return " (" . $this->messages->whereNotInStrict('administrator_id', null)->where('saw', false)->count() . ")";
                    });
            }),

        ];
    }
}
