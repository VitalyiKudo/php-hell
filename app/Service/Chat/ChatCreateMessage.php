<?php

namespace App\Service\Chat;

use App\Models\Message;
use Illuminate\Contracts\Auth\Authenticatable;

class ChatCreateMessage
{
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    protected Authenticatable $user;

    /**
     * @var int
     */
    protected int $roomId;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string $message
     * @param $roomId
     */
    public function __construct(Authenticatable $user, string $message, $roomId)
    {
        $this->user    = $user;
        $this->message = $message;
        $this->roomId  = $roomId;
    }

    /**
     * @return \App\Models\Message
     */
    public function handle(): Message
    {
        return $this->user->messages()->create(
            [
                'room_id' => $this->roomId,
                'message' => $this->message,
            ]
        );
    }
}
