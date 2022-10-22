<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NoticeController extends Controller
{
    public function index(){

        $notices = Notification::where('user_id', auth()->id())->latest()->get();
        return view('admin.notice.index', compact('notices'));
    }


    public function create(){
//        return \App\Models\Notification::where('user_id', auth()->id())->latest()->get();
        $collectors = User::where('user_type', 4)->pluck('name', 'id');
        $managers = User::where('user_type', 1)->pluck('name', 'id');
        $supervisors = User::where('user_type', 2)->pluck('name', 'id');
//       $admins = User::role('Admin')->pluck('name', 'id');
        $linguists = User::role('Linguist')->pluck('name', 'id');

        return view('admin.notice.create', compact('collectors', 'managers', 'supervisors', 'linguists'));
    }


    public function sendNotice(Request $request){
        $request->validate([
            'title' => 'required',
            'user_id' => 'required',
            'body' => 'required',
        ]);
        foreach ($request->user_id as $key => $value){
            $notice= new Notification();
            $notice->user_id = $value;
            $notice->title = $request->title;
            $notice->body = $request->body;
            $notice->created_by = auth()->id();
            $notice->updated_by = 0;
            $notice->save();
        }

        return redirect()->back()->with('success', __('messages.বিজ্ঞপ্তিটি সফলভাবে পাঠানো হয়েছে।'));
    }

    public function seenNotice($id){
        $notice= Notification::findOrFail($id);
        if ($notice->status == 0){
            $notice->status = 1;
            $notice->updated_by = auth()->id();
            $notice->updated_at = Carbon::now();
            $notice->update();
        }

        return view('admin.notice.view', compact('notice'));
    }


    public function destroy($id)
    {
        $notification = Notification::findOrfail($id);
        $notification->delete();

        return redirect()->back()->with('success', __('messages.বিজ্ঞপ্তিটি সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
