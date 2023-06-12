<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Config;
use App\Models\TemplateEmail;
use Illuminate\Bus\Queueable;
use App\Models\ConversationItem;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Properties\TextProperty;
use Spatie\IcalendarGenerator\Components\Event;

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

        $user = null;

        if ($notifiable instanceof AnonymousNotifiable) {
            $mail = $notifiable->routes['mail'];
            $user = new User();
            $user->name  = array_values($mail)[0];
            $user->email = array_keys($mail)[0];
        } else {
            $user = User::find($notifiable->id);
        }

        $adresses = "";
        foreach ($this->conversationItem->addresses as $key => $adress) {
            $adresses .= "<p>$adress->address_name - $adress->address</p>";
        }

        $values = [
            $user->full_name,
            $this->conversationItem->conversation->customer->customer ? $this->conversationItem->conversation->customer->customer->name : '-',
            $this->conversationItem->conversation->customer->name,
            $this->conversationItem->schedule_name ? $this->conversationItem->schedule_name : '-',
            $this->conversationItem->schedule_at ? $this->conversationItem->schedule_at->format("d/m/Y H:i") : '-',
            $this->conversationItem->organizer ? $this->conversationItem->organizer->full_name : '-',
            $this->conversationItem->organizer ? $this->conversationItem->organizer->email : '-',
            $adresses,
            $this->conversationItem->teams_url ? $this->conversationItem->teams_url : '-',
            $this->conversationItem->schedule_details ? $this->conversationItem->schedule_details : '-',
            Config::get("mail_signature"),
            $this->conversationItem->teams_id,
            $this->conversationItem->teams_token,
            $this->conversationItem->schedule_end ? $this->conversationItem->schedule_end->format("d/m/Y H:i") : '-',
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
