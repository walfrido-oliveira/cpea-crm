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
        $user = null;

        if ($notifiable instanceof AnonymousNotifiable) {
            $mail = $notifiable->routes['mail'];
            $user = new User();
            $user->name  = array_values($mail)[0];
            $user->email = array_keys($mail)[0];
        } else {
            $user = User::find($notifiable->id);
        }

        $tags = TemplateEmail::where("name", "new_schedule")->first()->tags;
        $tags = explode(",", $tags);

        $status = '-';

        if($this->conversationItem->projectStatus) $status = $this->conversationItem->projectStatus->name;
        if($this->conversationItem->proposedStatus) $status = $this->conversationItem->proposedStatus->name;
        if($this->conversationItem->prospectingStatus) $status = $this->conversationItem->prospectingStatus->name;

        $values = [
            $user ? $user->full_name : '-',
            $this->conversationItem->schedule_name ? $this->conversationItem->schedule_name : '-',
            $this->conversationItem->schedule_at ? $this->conversationItem->schedule_at->format("d/m/Y H:i") : '-',
            $this->conversationItem->schedule_details ? $this->conversationItem->schedule_details : '-',

            $this->conversationItem->conversation->customer->customer ? $this->conversationItem->conversation->customer->customer->name : '-',
            route('customers.show', ['customer' => $this->conversationItem->conversation->customer->customer_id ?
            $this->conversationItem->conversation->customer->customer_id : $this->conversationItem->conversation->customer->id]),
            $this->conversationItem->conversation->customer->name,
            route('customers.show', ['customer' => $this->conversationItem->conversation->customer_id]),
            str_pad($this->conversationItem->conversation_id, 5, 0, STR_PAD_LEFT),
            route('customers.conversations.show', ['conversation' => $this->conversationItem->conversation_id]),
            str_pad($this->conversationItem->order, 5, 0, STR_PAD_LEFT),
            route('customers.conversations.item.show', ['item' => $this->conversationItem->id]),

            $this->conversationItem->user->full_name,
            $this->conversationItem->interaction_at ? $this->conversationItem->interaction_at->format("d/m/Y H:i") : '-',
            $this->conversationItem->item_type,
            $status,
            $this->conversationItem->detailed_contact ? $this->conversationItem->prospecting_status->contact : '-',
            implode(",", $this->conversationItem->products->pluck('name')->toArray()),
            $this->conversationItem->direction ? $this->conversationItem->direction->name : '-',
            optional(optional($this->conversationItem->employee)->department)->name ?? '-',
            $this->conversationItem->employee ? $this->conversationItem->employee->name : '-',
            Config::get("mail_signature"),
        ];

        return (new MailMessage())
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

    /**
     * Create a notification instance.
     *
     * @return NewUserNotification
     */
    public static function create()
    {
        $conversationItem = ConversationItem::find(6);

        $notification = new NewScheduleNotification($conversationItem);
        return $notification;
    }
}
