<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AzureAcessController extends Controller
{
    public function token()
    {
        $tenantId = env('AZURE_TENANT_ID', '');
        $clientId = env('AZURE_CLIENT_ID', '');
        $clientSecret = env('AZURE_CLIENT_SECRET', '');

        $guzzle = new \GuzzleHttp\Client();
        $url = "https://login.microsoftonline.com/$tenantId/oauth2/v2.0/token";
        $token = json_decode($guzzle->post($url, [
            'form_params' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'scope' => 'https://graph.microsoft.com/.default',
                'grant_type' => 'client_credentials',
            ],
        ])->getBody()->getContents());
        $accessToken = $token->access_token;

        return $accessToken;
    }

    public function createOnlineMeeting(Request $request)
    {
        $userId = env('AZURE_USER_ID', '');
        $data =  [
            "startDateTime" => "2019-07-12T14:30:34.2444915-07:00",
            "endDateTime" => "2019-07-12T15:00:34.2464912-07:00",
            "subject" => "User Token Meeting"
        ];
        $token = $this->token();

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

        return $response;
    }
}
