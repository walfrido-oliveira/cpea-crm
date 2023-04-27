<?php

namespace App\Listeners;

use App\Events\CreatedUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailCreatedUser
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
     * @param  CreatedUser  $event
     * @return void
     */
    public function handle(CreatedUser $event)
    {
        $user = $event->user;
        $user->sendNewUserNotification();
    }
}
