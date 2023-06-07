<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineMeeting extends Model
{
    public static function createOnlineMeeting(ConversationItem $conversationItem, $userId)
    {
        $data =  [
            "startDateTime" => $conversationItem->schedule_at,
            "endDateTime" => $conversationItem->schedule_at->addHour(),
            "subject" => $conversationItem->schedule_name
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

            ])->getBody()->getContents());

        return $response->joinWebUrl;
    }

    public static function createEvent(ConversationItem $conversationItem, $userId)
    {
        $attendees[] = [
            "emailAddress" => [
               "address" => $conversationItem->user->email,
               "name" => $conversationItem->user->full_name
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

        $data =   [
            "subject" => $conversationItem->schedule_name,
            "body" => [
                  "contentType" => "HTML",
                  "content" => $conversationItem->schedule_details
               ],
            "start" => [
                     "dateTime" => $conversationItem->schedule_at,
                     "timeZone" => "E. South America Standard Time"
                  ],
            "end" => [
                        "dateTime" => $conversationItem->schedule_at->addHour(),
                        "timeZone" => "E. South America Standard Time"
                     ],
            "location" => [
                           "displayName" => $conversationItem->meeting_place ? $conversationItem->meeting_place : "-"
                        ],
            "attendees" => [$attendees],
            "allowNewTimeProposals" => true,
            "transactionId" => "7E163156-7762-4BEB-A1C6-729EA81755A7"
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

            ])->getBody()->getContents());

        return $response->joinWebUrl;
    }
}
