<?php

use App\Models\Notification;

if (! function_exists('getNotification')) {

    function getNotification($id)
    {
        $notification = Notification::where('user_id',$id)->where('status',0)->latest()->get();

        if (! empty($notification)) {
            return $notification;
        }
        return [];
    }

}
