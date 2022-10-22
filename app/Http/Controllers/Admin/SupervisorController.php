<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataCollectorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use File;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supervisors = User::where('user_type', 2)->latest()->get();

        return view('admin.supervisor.index', compact('supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supervisor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDataCollectorRequest $request)
    {
        $supervisor =new User();
        $supervisor->name = $request->name;
        $supervisor->join_date = $request->join_date;
        $supervisor->email = $request->email;
        $supervisor->password = Hash::make($request->password);
        $supervisor->phone = $request->phone;
        $supervisor->nid = $request->nid;
        $supervisor->education = $request->education;
        $supervisor->short_bio = $request->short_bio;
        $supervisor->address = $request->address;
        $supervisor->user_type = 2;
        $supervisor->created_by = auth()->id();

        $avatar_image = $request->avatar;
        $avatar_image_new_name = time() . $avatar_image->getClientOriginalName();
        $avatar_image->move('uploads/users', $avatar_image_new_name);
        $supervisor->avatar = 'uploads/users/' . $avatar_image_new_name;
        $supervisor->assignRole('Data Collection Supervisor');

        $supervisor->save();
        $supervisor->assignRole('Data Collection Supervisor');

        return redirect()->route('admin.supervisors.index')
            ->with('success', __('messages.সুপারভাইজর সফলভাবে তৈরি করা হয়েছে।'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $supervisor)
    {
        return view('admin.supervisor.show', compact('supervisor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $supervisor)
    {
        return view('admin.supervisor.edit', compact('supervisor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $supervisor)
    {
        $request->validate([
            'name'  => 'required|string',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($supervisor)],
            'join_date'    => 'required|date',
            'phone'    => ['required','regex:/(01)[0-9]{9}/', 'min:11','max:11',Rule::unique('users', 'phone')->ignore($supervisor)],
            'nid'    => ['required','max:20', Rule::unique('users', 'nid')->ignore($supervisor)],
        ]);

        $supervisor->name = $request->name;
        $supervisor->join_date = $request->join_date;
        $supervisor->email = $request->email;
        $supervisor->phone = $request->phone;
        $supervisor->nid = $request->nid;
        $supervisor->education = $request->education;
        $supervisor->short_bio = $request->short_bio;
        $supervisor->address = $request->address;
        $supervisor->user_type = 2;
        $supervisor->updated_by = auth()->id();

        if (!empty($request->password)){
            $request->validate([
                'password' => 'required|min:8|confirmed',
                'password_confirmation'     => 'required',
            ]);
            $supervisor->password = Hash::make($request->password);
        }

        if(request()->hasFile('avatar') && request('avatar') != ''){
            $imagePath = public_path($supervisor->avatar);

            if(File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $avatar_image = $request->avatar;
            $avatar_image_new_name = time() . $avatar_image->getClientOriginalName();
            $avatar_image->move('uploads/users', $avatar_image_new_name);
            $supervisor->avatar = 'uploads/users/' . $avatar_image_new_name;
        }
        $supervisor->update();

        return redirect()->back()->with('success', __('messages.সুপারভাইজর সফলভাবে আপডেট করা হয়েছে।'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $supervisor)
    {
        $imagePath = public_path($supervisor->avatar);

        if(File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $supervisor->delete();

        return redirect()->back()->with('success', __('messages.সুপারভাইজর সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
