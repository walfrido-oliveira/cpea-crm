<?php

namespace App\Notifications;

use App\Models\Config;
use App\Models\ConversationItem;
use App\Models\TemplateEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Spatie\IcalendarGenerator\Components\Event;
use Illuminate\Notifications\Messages\MailMessage;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Properties\TextProperty;

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
        $calendar = Calendar::create()
            ->productIdentifier('Kutac.cz')
            ->event(function (Event $event) {
                $event->name($this->conversationItem->schedule_name ? $this->conversationItem->schedule_name : '-')
                    ->attendee( $this->conversationItem->user->email)
                    ->startsAt($this->conversationItem->schedule_at ? $this->conversationItem->schedule_at : null)
                    ->endsAt($this->conversationItem->schedule_at ? $this->conversationItem->schedule_at : null)
                    ->fullDay()
                    ->address($this->conversationItem->schedule_details ? $this->conversationItem->schedule_details : '-');
            });
        $calendar->appendProperty(TextProperty::create('METHOD', 'REQUEST'));

        $tags = TemplateEmail::where("name", "new_schedule")->first()->tags;
        $tags = explode(",", $tags);

        $status = '-';

        if($this->conversationItem->projectStatus) $status = $this->conversationItem->projectStatus->name;
        if($this->conversationItem->proposedStatus) $status = $this->conversationItem->proposedStatus->name;
        if($this->conversationItem->prospectingStatus) $status = $this->conversationItem->prospectingStatus->name;

        $values = [
            $this->conversationItem->organizer ? $this->conversationItem->organizer->full_name : '-',
            $this->conversationItem->schedule_name ? $this->conversationItem->schedule_name : '-',
            $this->conversationItem->schedule_at ? $this->conversationItem->schedule_at->format("d/m/Y H:i") : '-',
            $this->conversationItem->schedule_details ? $this->conversationItem->schedule_details : '-',

            $this->conversationItem->conversation->customer->customer ? $this->conversationItem->conversation->customer->customer->name : '-',
            route('customers.show', ['customer' => $this->conversationItem->conversation->customer->customer_id]),
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
            $this->conversationItem->employee ? $this->conversationItem->employee->department->name : '-',
            $this->conversationItem->employee ? $this->conversationItem->employee->name : '-',
            Config::get("mail_signature"),
            #$this->conversationItem->additive ? 'SIM' : 'NÃO',
            #$this->conversationItem->conversation->cpea_linked_id ? $this->conversationItem->conversation->cpea_linked_id : '-',
            #$this->conversationItem->schedule_type ? $this->conversationItem->schedule_type : '-',
            #$this->conversationItem->addressees ? $this->conversationItem->addressees : '-',
            #$this->conversationItem->optional_addressees ? $this->conversationItem->optional_addressees : '-',
            #$this->conversationItem->item_details ? $this->conversationItem->item_details : '-',
        ];
        return (new MailMessage())
            ->attachData($calendar->get(), 'invite.ics', [
                'mime' => 'text/calendar; charset=UTF-8; method=REQUEST',
            ])
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
