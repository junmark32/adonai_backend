<?php

namespace App\Controllers;

use App\Controllers\BaseController;


use Config\Firebase;
use GuzzleHttp\Client;
class NotificationController extends BaseController
{
    public function index()
    {
        //
    }

    public function send()
    {
        $client = new Client();

        $response = $client->post('https://fcm.googleapis.com/v1/projects/' . Firebase::PROJECT_ID . '/messages:send', [
            'headers' => [
                'Authorization' => 'Bearer ' . Firebase::API_KEY,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'message' => [
                    'token' => 'DEVICE_TOKEN_OR_TOPIC',
                    'notification' => [
                        'title' => 'Your notification title',
                        'body' => 'Your notification body',
                    ],
                    'data' => [
                        'custom_key' => 'custom_value',
                    ],
                ],
            ],
        ]);

        // Handle response
        $body = $response->getBody();
        echo $body;
    }
}
