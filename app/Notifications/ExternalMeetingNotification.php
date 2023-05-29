<?php

namespace App\Notifications;

use App\Models\Config;
use App\Models\ConversationItem;
use App\Models\TemplateEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ExternalMeetingNotification extends Notification
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
        $tags = TemplateEmail::where("name", "external_meeting")->first()->tags;
        $tags = explode(",", $tags);

        $user = User::find($notifiable->id);

        $values = [
            $user->full_name,
            $this->conversationItem->conversation->customer->customer ? $this->conversationItem->conversation->customer->customer->name : '-',
            $this->conversationItem->conversation->customer->name,
            $this->conversationItem->schedule_name ? $this->conversationItem->schedule_name : '-',
            $this->conversationItem->schedule_at ? $this->conversationItem->schedule_at->format("d/m/Y H:i") : '-',
            $this->conversationItem->organizer ? $this->conversationItem->organizer->full_name : '-',
            $this->conversationItem->organizer ? $this->conversationItem->organizer->email : '-',
            count($this->conversationItem->addresses) > 0 ? implode(",", $this->conversationItem->addresses->pluck("address")->toArray()) : '-',
            $this->conversationItem->meeting_place ? $this->conversationItem->meeting_place : '-',
            $this->conversationItem->schedule_details ? $this->conversationItem->schedule_details : '-',
            Config::get("mail_signature"),
        ];
        return (new MailMessage())
            ->subject(str_replace($tags, $values, TemplateEmail::getSubject('external_meeting')))
            ->line(new HtmlString(str_replace($tags, $values, TemplateEmail::getValue('external_meeting'))));
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

    /**
     * Create a notification instance.
     *
     * @return NewUserNotification
     */
    public static function create()
    {
        $conversationItem = ConversationItem::find(6);

        $notification = new ExternalMeetingNotification($conversationItem);
        return $notification;
    }
}
