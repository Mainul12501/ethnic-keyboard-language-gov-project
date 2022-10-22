<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class NotificationController extends Controller
{

    public function index(){

        $notifications = Notification::latest()->get();
        return view('admin.notification.index', compact('notifications'));
    }


    public function create(){
//        return \App\Models\Notification::where('user_id', auth()->id())->latest()->get();
        $collectors = User::where('user_type', 4)->pluck('name', 'id');
        $managers = User::where('user_type', 1)->pluck('name', 'id');
        $supervisors = User::where('user_type', 2)->pluck('name', 'id');
//       $admins = User::role('Admin')->pluck('name', 'id');
        $linguists = User::role('Linguist')->pluck('name', 'id');

        return view('admin.notification.create', compact('collectors', 'managers', 'supervisors', 'linguists'));
    }


    public function sendNotification(Request $request){
        $request->validate([
            'title' => 'required',
            'user_id' => 'required',
            'body' => 'required',
        ]);
        foreach ($request->user_id as $key => $value){
            $notification= new Notification();
            $notification->user_id = $value;
            $notification->title = $request->title;
            $notification->body = $request->body;
            $notification->created_by = auth()->id();
            $notification->updated_by = 0;
            $notification->save();
        }

        return redirect()->back()->with('success', 'Send Notification has been Successfully');
    }

    public function seenNotification($id){
        $notification= Notification::findOrFail($id);
        if ($notification->status == 0){
            $notification->status = 1;
            $notification->updated_by = auth()->id();
            $notification->updated_at = Carbon::now();
            $notification->update();
        }

        return view('admin.notification.view', compact('notification'));
    }


    public function destroy($id)
    {
        $notification = Notification::findOrfail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notification has been deleted Successfully');
    }
}
