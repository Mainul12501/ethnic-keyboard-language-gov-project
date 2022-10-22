<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;


class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('notice');
    }

    public function storeToken(Request $request)
    {

        auth()->user()->update(['fcm_token'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }

    public function sendNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $SERVER_API_KEY = 'AAAA7y2pqWA:APA91bE3xsrTVedzM9_X6sE1qTViIkHM5MZNIt5BkHnPCS3fTq9A4frRUqVZ1N3S__1UWa-q3lXCshW8I3ym9TbehqcOyyCOHmETQQtW3N8h4iRQ0dgV6zmyv8tF3VO24SCVFc_HAoSL';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
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
        dd($result);

    }
    public function clearNotification(Request $request)
    {
        try {

            $notification = Notification::where('user_id',$request->user_id)->where('id',$request->not_id)->first();
            $notification->update([

                'status' => 1
            ]);

            $not_count = Notification::where('user_id',$request->user_id)->where('status',0)->count();

            return response()->json(['message' => 'Notification removed', 'count' => $not_count]);

        } catch (\Throwable $th) {

            return response()->json(['message' => 'Something went wrong!']);
        }
    }
}
