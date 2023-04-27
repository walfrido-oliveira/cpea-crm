<?php

namespace App\Listeners;

use App\Events\UpdatedUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailUpdatedUser
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
     * @param  UpdatedUser  $event
     * @return void
     */
    public function handle(UpdatedUser $event)
    {
        $user = $event->user;
        $user->sendUpdateUserInformationNotification();
    }
}
