<?php

namespace App\Notifications;

use Carbon\Carbon;
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
                $event->name("Email with iCal 101")
                    ->attendee("attendee@gmail.com")
                    ->startsAt(Carbon::parse("2021-12-15 08:00:00"))
                    ->endsAt(Carbon::parse("2021-12-19 17:00:00"))
                    ->fullDay()
                    ->address('Online - Google Meet');
            });
        $calendar->appendProperty(TextProperty::create('METHOD', 'REQUEST'));

        $tags = [
            "{\$conversation_id}",
            "{\$customer_name}",
            "{\$company_name}",
            "{\$user_first_name}",
            "{\$signature}",
            "{\$item_type}",
            "{\$interaction_at}",
            "{\$schedule_at}",
            "{\$additive}",
            "{\$cpea_linked_id}",
            "{\$schedule_type}",
            "{\$schedule_name}",
            "{\$addressees}",
            "{\$optional_addressees}",
            "{\$schedule_details}",
            "{\$item_details}",
            "{\$project_status}",
            "{\$proposed_status}",
            "{\$prospecting_status}",
            "{\$detailed_contact}",
            "{\$organizer}",
            "{\$products}",
        ];
        $values = [
            str_pad($this->conversationItem->conversation_id, 5, 0, STR_PAD_LEFT),
            $this->conversationItem->conversation->customer->customer ? $this->conversationItem->conversation->customer->customer->name : '-',
            $this->conversationItem->conversation->customer->name,
            $this->conversationItem->user->full_name,
            Config::get("mail_signature"),
            $this->conversationItem->item_type,
            $this->conversationItem->interaction_at ? $this->conversationItem->interaction_at->format("d/m/Y H:i") : '-',
            $this->conversationItem->schedule_at ? $this->conversationItem->schedule_at->format("d/m/Y H:i") : '-',
            $this->conversationItem->additive ? 'SIM' : 'NÃO',
            $this->conversationItem->conversation->cpea_linked_id ? $this->conversationItem->conversation->cpea_linked_id : '-',
            $this->conversationItem->schedule_type ? $this->conversationItem->schedule_type : '-',
            $this->conversationItem->schedule_name ? $this->conversationItem->schedule_name : '-',
            $this->conversationItem->addressees ? $this->conversationItem->addressees : '-',
            $this->conversationItem->optional_addressees ? $this->conversationItem->optional_addressees : '-',
            $this->conversationItem->schedule_details ? $this->conversationItem->schedule_details : '-',
            $this->conversationItem->item_details ? $this->conversationItem->item_details : '-',
            $this->conversationItem->projectStatus ? $this->conversationItem->projectStatus->name : '-',
            $this->conversationItem->proposedStatus ? $this->conversationItem->proposedStatus->name : '-',
            $this->conversationItem->prospectingStatus ? $this->conversationItem->prospectingStatus->name : '-',
            $this->conversationItem->detailed_contact ? $this->conversationItem->prospecting_status->contact : '-',
            $this->conversationItem->organizer ? $this->conversationItem->organizer->full_name : '-',
            implode(",", $this->conversationItem->products->pluck('name')->toArray()),
        ];
        return (new MailMessage())
            ->subject("Invitation")
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
