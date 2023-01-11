<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;

class UserEventListener
{
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserRegisteredEvent $event
     * @return void
     * @internal param $user .registered  $event
     */
    public function handle(UserRegisteredEvent $event)
    {

    }
}
