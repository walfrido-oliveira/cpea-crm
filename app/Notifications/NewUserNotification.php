<?php

namespace App\Notifications;

use App\Models\Config;
use App\Models\TemplateEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserNotification extends Notification
{
    use Queueable;

    private $url;
    private $user;

    /**
     * Create a notification instance.
     *
     * @param  User    $user
     * @param  string  $url
     * @return void
     */
    public function __construct($user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

     /**
     * Create a notification instance.
     *
     * @return NewUserNotification
     */
    public static function create()
    {
        $user = auth()->user();

        $url = config('app.url');

        $notification = new NewUserNotification($user, $url);
        return $notification;
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
        $tags = [
            "{\$user_first_name}",
            "{\$create_account_url}",
            "{\$signature}"
        ];
        $values = [
            $this->user->name,
            $this->url,
            Config::get("mail_signature"),
        ];
        return (new MailMessage)
            ->subject(str_replace($tags, $values, TemplateEmail::getSubject('new_user_created')))
            ->line(new HtmlString(str_replace($tags, $values, TemplateEmail::getValue('new_user_created'))));
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
