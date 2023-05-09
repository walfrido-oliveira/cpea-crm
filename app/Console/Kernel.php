<?php

namespace App\Console;

use App\Models\ConversationItem;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $conversationItems = ConversationItem::
            whereRaw("date(schedule_at) - interval 30 day = current_date() or date(schedule_at) - interval 15 day = current_date() or
            date(schedule_at) - interval 10 day = current_date() or date(schedule_at) - interval 5 day = current_date() or
            date(schedule_at) - interval 1 day = current_date() or date(schedule_at) = current_date() or schedule_at = current_timestamp()")->get();

            foreach ($conversationItems as $conversationItem) {
                $conversationItem->user->sendScheduleNotification($conversationItem);
            }

        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
