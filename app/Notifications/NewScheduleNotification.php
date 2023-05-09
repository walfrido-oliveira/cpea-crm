<?php

namespace App\Notifications;

use App\Models\TemplateEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewScheduleNotification extends Notification
{
    use Queueable;

    private $conversationItem;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($conversationItem)
    {
        $this->conversationItem = $conversationItem;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $tags = [];
        $values = [];
        return (new MailMessage)
            ->subject(str_replace($tags, $values, TemplateEmail::getSubject('new_schedule')))
            ->line(new HtmlString(str_replace($tags, $values, TemplateEmail::getValue('new_schedule'))));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
