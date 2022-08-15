<?php

namespace App\Service\Chat;

use App\Models\Administrator;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Contracts\Pagination\Paginator;

class  ChatRoom
{
    protected const GUARD_CLIENT = 'client';
    protected const GUARD_API    = 'api';

    /**
     * @var string[]
     */
    protected static $guards = [
        self::GUARD_CLIENT,
        self::GUARD_API
    ];

    /**
     * @param string $quard
     * @param int|null $page
     * @param string|null $email
     * @return \App\Models\Room[]|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function getRoomsOrCreateNew(string $quard, ?int $page, ?string $email)
    {
        if (array_search($quard, self::$guards) === false) {
            throw new \Exception('Unpredictable guard');
        }

        if (auth()->guard($quard)->check()) {
            if (auth()->user()->rooms()->count() < 1) {
                $this->createRoom($quard);
            }
            return Room::with('messages', 'user')->where('user_id', auth()->user()->id)->limit(1)->paginate();
        }

        return $this->getAdminRooms($page, $email);

    }

    /**
     * @param string $quard
     * @return void
     */
    protected function createRoom(string $quard): void
    {
        /**
         * @var Room $room
         */
        $room = auth()->user()->rooms()->create(
            [
                'name' => auth()->guard($quard)->user()->email
            ]
        );

        $admins = Administrator::all();
        $room->administrators()->attach($admins);
    }

    /**
     * @param int $page
     * @param string $email
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    protected function getAdminRooms(?int $page, ?string $email): Paginator
    {
        return Room::with('messages', 'user', 'administrators')
            ->whereHas('user', function ($query) use ($email) {
                $query->where('email', 'like', "%$email%");
            })
            ->paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page);
    }

    /**
     * @param \App\Models\Room $room
     * @param int|null $page
     * @param string|null $text
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function searchMessage(Room $room, ?int $page, string $text = null): Paginator
    {
        return Message::with('user', 'administrator')
            ->where('room_id', $room->id)
            ->where('message', 'like', "%$text%")
            ->latest()
            ->simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page', $page);
    }
}
