<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Session;
use File;
use Spatie\Activitylog\Models\Activity;

class BackendController extends Controller
{

    public function profile(){

        $user = Auth::user();

        return view('user.profile', compact('user'));
    }


    public function updateProfile(Request  $request){
        $user = Auth::user();

        $request->validate([
            'name'      => 'required|string',
            'email'     => ['required', Rule::unique('users')->ignore($user->id)],
            'phone'    => ['required','regex:/(01)[0-9]{9}/', 'min:11', 'max:11', Rule::unique('users')->ignore($user->id)],
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if(request()->hasFile('avatar') && request('avatar') != ''){
            $imagePath = public_path($user->avatar);

            if(File::exists($imagePath)) {
                File::delete($imagePath);
//                 unlink($imagePath);
            }
            $avatar_image = $request->avatar;
            $avatar_image_new_name = time() . $avatar_image->getClientOriginalName();
            $avatar_image->move('uploads/users', $avatar_image_new_name);
            $user->avatar = 'uploads/users/' . $avatar_image_new_name;
        }
        $user->update();

        return redirect()->back()->with('success', __('messages.প্রোফাইল সফলভাবে আপডেট করা হয়েছে।'));
    }

    public function updatePassword(Request  $request){

        $request->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation'     => 'required',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->update();

        return redirect()->back()->with('success', __('messages.পাসওয়ার্ড সফলভাবে আপডেট করা হয়েছে।'));
    }




    public function getCollection($id){
        $collection=DataCollection::findOrFail($id);
        if ($collection->type_id == 1){
            $collection = DataCollection::with(['taskAssign.group', 'language', 'district', 'speaker','collector', 'dcDirected'=>function($q){
                $q->with('topic','dcSentence.directed')->get();
            } ])->findOrFail($id);
        }else{
            $collection = DataCollection::with(['taskAssign.group', 'language', 'district', 'speaker','collector', 'dcSpontaneous'=>function($q){
                $q->with('spontaneous')->get();
            } ])->findOrFail($id);
        }

        return  view('admin.data_collection.viewCollection', compact('collection'));
    }


    public function activity(){
        $activities= Activity::with('causer')->where('causer_id', auth()->id())->latest()->get();

        return view('activity', compact('activities'));

    }

}
