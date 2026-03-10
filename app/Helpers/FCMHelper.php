<?php

namespace App\Helpers;

use Google\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FCMHelper
{
    /**
     * Send push notification using Firebase Cloud Messaging API v1
     */
    public static function sendNotification($tokens, $title, $body, $data = [])
    {
        if (empty($tokens)) {
            return false;
        }

        if (!is_array($tokens)) {
            $tokens = [$tokens];
        }

        // Filter out empty tokens
        $tokens = array_filter($tokens);
        if (empty($tokens)) {
            return false;
        }

        try {
            $credentialsFilePath = storage_path('app/firebase_credentials.json');
            
            if (!file_exists($credentialsFilePath)) {
                Log::error("Firebase credentials file not found at: {$credentialsFilePath}");
                return false;
            }

            $client = new Client();
            $client->setAuthConfig($credentialsFilePath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            
            $tokenConfig = $client->fetchAccessTokenWithAssertion();
            
            if (isset($tokenConfig['error'])) {
                Log::error("Error generating FCM token: " . $tokenConfig['error']);
                return false;
            }
            
            $accessToken = $tokenConfig['access_token'];
            
            $jsonFile = json_decode(file_get_contents($credentialsFilePath), true);
            $projectId = $jsonFile['project_id'] ?? env('FIREBASE_PROJECT_ID');
            
            if (!$projectId) {
                Log::error("Firebase project ID not found in credentials file or .env");
                return false;
            }

            $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
            
            // Format data values to string as required by FCM API
            $formattedData = [];
            foreach ($data as $key => $val) {
                $formattedData[$key] = (string) $val;
            }

            // Send in chunks to avoid timeout and pool efficiently
            $chunks = array_chunk($tokens, 100);
            foreach ($chunks as $chunk) {
                $responses = Http::pool(fn ($pool) => collect($chunk)->map(function ($deviceToken) use ($pool, $url, $accessToken, $title, $body, $formattedData) {
                    $messagePayload = [
                        'message' => [
                            'token' => $deviceToken,
                            'notification' => [
                                'title' => $title,
                                'body' => $body,
                            ],
                        ]
                    ];
                    
                    if (!empty($formattedData)) {
                        $messagePayload['message']['data'] = $formattedData;
                    }

                    return $pool->withToken($accessToken)->asJson()->post($url, $messagePayload);
                }));

                // Check for errors
                foreach ($responses as $response) {
                    if ($response instanceof \Illuminate\Http\Client\Response && !$response->successful()) {
                        Log::error("FCM Send Error: " . $response->body());
                    }
                }
            }

            return true;
        } catch (\Exception $e) {
            Log::error("FCM Exception: " . $e->getMessage());
            return false;
        }
    }
}
