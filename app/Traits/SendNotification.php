<?php

namespace App\Traits;

use App\Models\User;

trait SendNotification{

    // Sending Notification

    public function Notification($title,$body)
    {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $SERVER_API_KEY = 'AAAA7y2pqWA:APA91bE3xsrTVedzM9_X6sE1qTViIkHM5MZNIt5BkHnPCS3fTq9A4frRUqVZ1N3S__1UWa-q3lXCshW8I3ym9TbehqcOyyCOHmETQQtW3N8h4iRQ0dgV6zmyv8tF3VO24SCVFc_HAoSL';

        $data = [
            "registration_ids" => $firebaseToken,
            // "registration_ids" => 'ddof1KKRQKqlbSwNQ3t1g_:APA91bGbwXb9g4RelTLXaZRtUKQfOlGa8h8p66e2Si_kRmD7suoTfVwqAHChel5Sb-gAWCpfLm9GZQnnVN6zpMR80hiLJM8nUPEN10eK0hjE2J1HjQRqcSlMx7kBfKsDSQYcsz23MO8_',
            "notification" => [
                "title" => $title,
                "body" => $body,
                "content_available" => true,
                "priority" => "high",
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
    }
}
