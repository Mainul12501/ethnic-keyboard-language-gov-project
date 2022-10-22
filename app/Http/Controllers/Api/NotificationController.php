<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{

    public function getNotification($id)
    {
        $notification = Notification::where('user_id',$id)->where('status',0)->first();
        $fcm_token    = User::select('fcm_token')->where('id',$id)->first();

        if ($notification != null) {

            return response()->json([

                'title'        => $notification->title,
                'body'         => $notification->body,
                'status'       => $notification->status,
                'device_token' => $fcm_token
            ]);

        }else {

            return response()->json(['message' => 'No Notification Founnd']);
        }

    }
}
