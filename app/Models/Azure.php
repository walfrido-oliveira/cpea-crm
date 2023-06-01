<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Azure extends Model
{
    public static function token()
    {
        if(Cache::has("AZURE_TOKEN")) return Cache::get("AZURE_TOKEN");

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

        Cache::put("AZURE_TOKEN", $accessToken, 60 * 60);

        return $accessToken;
    }
}
