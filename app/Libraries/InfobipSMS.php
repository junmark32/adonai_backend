<?php

namespace App\Libraries;

class InfobipSMS
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        // Replace with your Infobip API Key
        $this->apiKey = 'YOUR_API_KEY';
        // Base URL for Infobip API, replace with your actual base URL
        $this->baseUrl = 'https://api.infobip.com';
    }

    public function sendSMS($to, $message)
    {
        $curl = curl_init();
        $postData = json_encode([
            'messages' => [
                [
                    'destinations' => [
                        ['to' => $to],
                    ],
                    'from' => 'InfoSMS', // Set your sender ID
                    'text' => $message,
                ],
            ],
        ]);

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . '/sms/2/text/advanced',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => [
                'Authorization: App ' . $this->apiKey,
                'Content-Type: application/json',
                'Accept: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true); // Decode response to array
    }
}
