<?php

namespace App\Service\Chat;

use App\Models\Administrator;
use App\Models\Room;

class  ChatRoom
{

    /**
     * @param string $quard
     * @return \App\Models\Room[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getRoomsOrCreateNew(string $quard)
    {
        if (auth()->guard($quard)->check()) {
            if (auth()->user()->rooms()->count() < 1) {
                $room = auth()->user()->rooms()->create(
                    [
                        'name' => auth()->guard($quard)->user()->email
                    ]
                );

                $admins = Administrator::all();
                $room->administrators()->attach($admins);
            }
            return Room::with('messages','user')->where('user_id', auth()->user()->id)->get();
        }
        else {
            return Room::with('messages','user','administrators')->get();
        }

    }
}
