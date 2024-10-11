<?php

namespace App\Libraries;

use GuzzleHttp\Client;

class Semaphore
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = 'ad4811aa957df160ff00b39a18661395'; // Replace with your API key
    }

    public function sendSMS($to, $message)
    {
        try {
            $response = $this->client->request('POST', 'https://api.semaphore.co/api/v4/messages', [
                'json' => [
                    'apiKey' => $this->apiKey,
                    'number' => $to,
                    'message' => $message,
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
