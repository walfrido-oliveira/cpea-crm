<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineMeeting extends Model
{
    public static function createOnlineMeeting($startDateTime, $endDateTime, $subject, $userId)
    {
        $data =  [
            "startDateTime" => $startDateTime,
            "endDateTime" => $endDateTime,
            "subject" => $subject
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
}
