<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\ExternalMeetingNotification;

class OnlineMeeting extends Model
{
  public static function createOnlineMeeting(ConversationItem $conversationItem, $userId = NULL)
  {
    if ($userId == null) $userId = env('AZURE_USER_ONLINE_MEETING', '');

    $data =  [
      "startDateTime" => $conversationItem->schedule_at,
      "endDateTime" => $conversationItem->schedule_end,
      "subject" => $conversationItem->schedule_name,
      "joinMeetingIdSettings" => [
        "isPasscodeRequired" => true
      ]
    ];
    $token = Azure::token();

    $guzzle = new \GuzzleHttp\Client();
    $url = "https://graph.microsoft.com/v1.0/users/$userId/onlineMeetings/";
    $response = json_decode(
      $guzzle->post($url, [
        'headers' => [
          'Authorization' => "Bearer $token",
          'content-type' => 'application/json',
          'Accept-Language' => 'pt-BR'
        ],
        'body' => json_encode($data),

      ])->getBody()->getContents()
    );

    return $response;
  }

  public static function createEvent(ConversationItem $conversationItem, $userId = null)
  {
    if ($userId == null) $userId = env('AZURE_USER_ONLINE_MEETING', '');

    $notification = new ExternalMeetingNotification($conversationItem);
    $content = ($notification)->toMail(auth()->user());
    $html = view('config.emails.templates.show', compact('content'))->render();

    // Inline CSS styles to ensure they are applied in the email
    $html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $html);
    $html = preg_replace_callback('/<([a-z]+)([^>]*)>/i', function ($matches) {
      $tag = $matches[1];
      $attributes = $matches[2];
      if (preg_match('/style="([^"]*)"/i', $attributes, $styleMatches)) {
        $styles = $styleMatches[1];
        $attributes = preg_replace('/style="[^"]*"/i', '', $attributes);
        $attributes .= ' style="' . $styles . '"';
      }
      return "<$tag$attributes>";
    }, $html);

    $attendees[] = [
      "emailAddress" => [
        "address" => $conversationItem->organizer->email,
        "name" => $conversationItem->organizer->full_name
      ],
      "type" => "required"
    ];

    foreach ($conversationItem->addresses as $address) {
      $attendees[] = [
        "emailAddress" => [
          "address" => $address->address,
          "name" => $address->address_name
        ],
        "type" => "required"
      ];
    }

    $attendees[] = [
      "emailAddress" => [
        "address" => $conversationItem->organizer->email,
        "name" => $conversationItem->organizer->name
      ],
      "type" => "required"
    ];

    $data =   [
      "subject" => $conversationItem->schedule_name,
      "body" => [
        "contentType" => "HTML",
        "content" => $html
      ],
      "start" => [
        "dateTime" => $conversationItem->schedule_at,
        "timeZone" => "E. South America Standard Time"
      ],
      "end" => [
        "dateTime" => $conversationItem->schedule_end,
        "timeZone" => "E. South America Standard Time"
      ],
      "location" => [
        "displayName" => $conversationItem->meeting_place ? $conversationItem->meeting_place : "-"
      ],
      "attendees" => $attendees,
      "allowNewTimeProposals" => true,
    ];
    $token = Azure::token();

    $guzzle = new \GuzzleHttp\Client();
    $url = "https://graph.microsoft.com/v1.0/users/$userId/events/";
    $response = json_decode(
      $guzzle->post($url, [
        'headers' => [
          'Authorization' => "Bearer $token",
          'content-type' => 'application/json',
          'Accept-Language' => 'pt-BR'
        ],
        'body' => json_encode($data),

      ])->getBody()->getContents()
    );

    return $response;
  }
}
