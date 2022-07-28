<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public int $roomId;

    /**
     * @var \App\Models\Message
     */
    public  $message;

    /**
     * @param \App\Models\Message $message
     * @param int $roomId
     */
    public function __construct( $message, int $roomId)
    {
        $this->message = $message;
        $this->roomId  = $roomId;
    }

    /**
     * @return \Illuminate\Broadcasting\PresenceChannel
     */
    public function broadcastOn(): PresenceChannel
    {
        return new PresenceChannel('chat.' . $this->roomId);
    }
}
