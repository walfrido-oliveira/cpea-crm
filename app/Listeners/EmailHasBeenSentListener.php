<?php

namespace App\Listeners;

use App\Models\EmailAudit;
use Illuminate\Mail\Events\MessageSent;

class EmailHasBeenSentListener
{
    public function handle(MessageSent $event)
    {
        $subject        = $event->message->getSubject();
        $toArr          = $this->parseAddresses($event->message->getTo());
        $ccArr          = $this->parseAddresses($event->message->getCc());
        $fromArr        = $event->message->getFrom();
        $body           = $event->message->getBody();
        $user           = auth()->id() ?? NULL;

        EmailAudit::create([
            'user_id'   => $user,
            'from'      => $fromArr,
            'to'        => $toArr,
            'cc'        => $ccArr ? $ccArr : NULL,
            'subject'   => $subject,
            'body'      => $body,
        ]);

        return false;
    }

    private function parseAddresses(array|null $array): array
    {
        $parsed = [];
        $array = !is_array($array) ? [] : $array;
        foreach($array as $key => $address) {
            $parsed[] = $key;
        }
        return $parsed;
    }

    private function parseBodyText($body): string
    {
        return preg_replace('~[\r\n]+~', '<br>', $body);
    }
}
