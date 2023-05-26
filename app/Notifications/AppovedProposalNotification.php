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

class AppovedProposalNotification extends Notification
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
        $tags = TemplateEmail::where("name", "approved_proposal")->first()->tags;
        $tags = explode(",", $tags);

        $status = '-';

        if($this->conversationItem->projectStatus) $status = $this->conversationItem->projectStatus->name;
        if($this->conversationItem->proposedStatus) $status = $this->conversationItem->proposedStatus->name;
        if($this->conversationItem->prospectingStatus) $status = $this->conversationItem->prospectingStatus->name;

        $user = User::find($notifiable->id);

        $attachments = view('conversations.notification.attachments', ['attachments' => $this->conversationItem->attachments])->render();
        $values = view('conversations.notification.values', ['values' => $this->conversationItem->values])->render();

        $values = [
            $user->full_name,
            $this->conversationItem->conversation->cpea_id ? str_pad($this->conversationItem->conversation->cpea_id, 5, 0, STR_PAD_LEFT) : '-',
            $this->conversationItem->conversation->customer->customer ? $this->conversationItem->conversation->customer->customer->name : '-',
            $this->conversationItem->conversation->customer->name,
            str_pad($this->conversationItem->conversation_id, 5, 0, STR_PAD_LEFT),
            str_pad($this->conversationItem->order, 5, 0, STR_PAD_LEFT),
            $this->conversationItem->user->full_name,
            $this->conversationItem->interaction_at ? $this->conversationItem->interaction_at->format("d/m/Y H:i") : '-',
            $status,
            $this->conversationItem->detailed_contact ? $this->conversationItem->prospecting_status->contact : '-',
            implode(",", $this->conversationItem->products->pluck('name')->toArray()),
            $this->conversationItem->direction ? $this->conversationItem->direction->name : '-',
            $this->conversationItem->employee ? $this->conversationItem->employee->department->name : '-',
            $this->conversationItem->employee ? $this->conversationItem->employee->name : '-',
            $this->conversationItem->item_details,
            $attachments,
            $values,
            Config::get("mail_signature"),
        ];
        return (new MailMessage())
            ->subject(str_replace($tags, $values, TemplateEmail::getSubject('approved_proposal')))
            ->line(new HtmlString(str_replace($tags, $values, TemplateEmail::getValue('approved_proposal'))));
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

        $notification = new AppovedProposalNotification($conversationItem);
        return $notification;
    }
}
