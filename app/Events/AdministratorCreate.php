<?php

namespace App\Events;

use App\Models\Administrator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class AdministratorCreate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Administrator
     */
    public Administrator $administrator;

    /**
     * @param \App\Models\Administrator $administrator
     */
    public function __construct(Administrator $administrator)
    {
        $this->administrator = $administrator;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
