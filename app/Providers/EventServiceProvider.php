<?php

namespace App\Providers;

use App\Events\CreatedUser;
use App\Events\UpdatedUser;
use Illuminate\Support\Facades\Event;
use App\Listeners\SendMailCreatedUser;
use App\Listeners\SendMailUpdatedUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Mail\Events\MessageSent;
use App\Listeners\EmailHasBeenSentListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UpdatedUser::class => [
            SendMailUpdatedUser::class,
        ],
        CreatedUser::class => [
            SendMailCreatedUser::class,
        ],
        MessageSent::class => [
            EmailHasBeenSentListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
