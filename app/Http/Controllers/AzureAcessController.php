<?php

namespace App\Http\Controllers;

use Microsoft\Kiota\Abstractions\ApiException;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAuthenticationProvider;

class AzureAcessController extends Controller
{
    public function token()
    {
        $tenantId = env('AZURE_TENANT_ID', ''); //'1ca11bc3-43a7-411a-9fb5-7857f9b38626';
        $clientId = env('AZURE_CLIENT_ID', ''); //'d89a4a44-6929-4496-9711-a1b073e00ab4';
        $clientSecret = env('AZURE_CLIENT_SECRET', ''); //'U6t8Q~bt3ryfQh99RWN51G9UGhgQtc-LTSCVbaF-';

        $guzzle = new \GuzzleHttp\Client();
        $url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/v2.0/token';
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

    public function teste()
    {

    }
}
