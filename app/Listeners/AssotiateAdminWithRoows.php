<?php

namespace App\Listeners;

use App\Events\AdministratorCreate;
use App\Models\Room;

class AssotiateAdminWithRoows
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param AdministratorCreate $event
     * @return void
     */
    public function handle(AdministratorCreate $event)
    {
        $event->administrator->rooms()->attach(Room::all());
    }
}
