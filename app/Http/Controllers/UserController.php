<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use App\Models\DataCollection;
use App\Models\DCDirected;
use App\Models\DCDirectedSentence;
use App\Models\DCSpontaneous;
use App\Models\DirectedTaskAssign;
use App\Models\GroupCollectors;
use App\Models\SpontaneousTaskAssign;
use App\Models\TaskAssign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use File;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    // function __construct()
    // {
    //     $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
    //     $this->middleware('permission:user-create', ['only' => ['create','store']]);
    //     $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users =User::orderBy('id', 'desc')->get();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();

        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

        if ($request->role == "Manager"){
            $typeID=1;
        }elseif ($request->role == "Data Collection Supervisor"){
            $typeID=2;
        }elseif ($request->role == "Data Collector"){
             $typeID = 4;
        }elseif ($request->role == "Linguist"){
              $typeID = 5;
       }else{
             $typeID = 6;
        }

        $user =new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        if (!empty($typeID)){
            $user->user_type = $typeID;
        }
        $avatar_image = $request->avatar;
        $avatar_image_new_name = time() . $avatar_image->getClientOriginalName();
        $avatar_image->move('uploads/users', $avatar_image_new_name);
        $user->avatar = 'uploads/users/' . $avatar_image_new_name;
        $user->save();

        $user->assignRole($request->input('role'));

        return redirect()->route('admin.users.index')
            ->with('success', __('messages.ইউজার সফলভাবে তৈরি করা হয়েছে।'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
//        return$user;
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
//        dd($userRole);
        return view('user.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->role == "Manager"){
            $typeID=1;
        }elseif ($request->role == "Data Collection Supervisor"){
            $typeID=2;
        }elseif ($request->role == "Data Collector"){
            $typeID = 4;
        }elseif ($request->role == "Linguist"){
            $typeID = 5;
       }else{
             $typeID = 6;
       }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if (!empty($typeID)){
            $user->user_type = $typeID;
        }

        if(request()->hasFile('avatar') && request('avatar') != ''){
            $imagePath = public_path($user->avatar);

            if(File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $avatar_image = $request->avatar;
            $avatar_image_new_name = time() . $avatar_image->getClientOriginalName();
            $avatar_image->move('uploads/users', $avatar_image_new_name);
            $user->avatar = 'uploads/users/' . $avatar_image_new_name;
        }
        $user->update();

        DB::table('model_has_roles')
            ->where('model_id', $user->id)
            ->delete();

        $user->assignRole($request->input('role'));

        return redirect()->back()->with('success', __('messages.ইউজার সফলভাবে আপডেট করা হয়েছে।'));
    }
    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation'     => 'required',
        ]);

        $user->password = Hash::make($request->password);
        $user->update();
        return redirect()->back()->with('success', __('messages.ইউজার পাসওয়ার্ড সফলভাবে আপডেট করা হয়েছে।'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        /*if ($user->tasks()->count() && $user->groupCollectors()->count()){
            return back()->with(['error'=>'Cannot delete, Data Collector has Task and Group Records']);
        }
        if ($user->tasks()->count()){
            return back()->with(['error'=>'Cannot delete, Data Collector has Task Record']);
        }
        if ($user->groupCollectors()->count()){
            return back()->with(['error'=>'Cannot delete, Data Collector has Group Record']);
        }*/

        $imagePath = public_path($user->avatar);
        if(File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $user->delete();
        TaskAssign::where('user_id', $user->id)->delete();
        SpontaneousTaskAssign::where('user_id', $user->id)->delete();
        DirectedTaskAssign::where('user_id', $user->id)->delete();
        GroupCollectors::where('user_id', $user->id)->delete();
        $dataCollection =DataCollection::where('collector_id', $user->id)->first();
        if (!empty($dataCollection)){
            $dataCollection->delete();
            $dcDirected = DCDirected::where('data_collection_id', $dataCollection->id)->first();
            if (!empty($dcDirected)){
                $dcDirected->delete();
                $dcDirectedSentence = DCDirectedSentence::where('d_c_directed_id', $dcDirected->id)->first();
                $audioPath = public_path($dcDirectedSentence->audio);
                if(File::exists($audioPath)) {
                    File::delete($audioPath);
                }
                $dcDirectedSentence->delete();
            }else{

                $dcSpontaneous= DCSpontaneous::where('data_collection_id', $dataCollection->id)->first();
                $audioPath = public_path($dcSpontaneous->audio);
                if(File::exists($audioPath)) {
                    File::delete($audioPath);
                }
                $dcSpontaneous->delete();
            }
        }



        return redirect()->back()->with('success', __('messages.ইউজার সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
