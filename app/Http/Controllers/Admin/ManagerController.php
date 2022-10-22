<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataCollectorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use File;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $managers = User::where('user_type', 1)->latest()->get();

        return view('admin.manager.index', compact('managers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manager.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDataCollectorRequest $request)
    {
        $manager =new User();
        $manager->name = $request->name;
        $manager->join_date = $request->join_date;
        $manager->email = $request->email;
        $manager->password = Hash::make($request->password);
        $manager->phone = $request->phone;
        $manager->nid = $request->nid;
        $manager->education = $request->education;
        $manager->short_bio = $request->short_bio;
        $manager->address = $request->address;
        $manager->user_type = 1;
        $manager->created_by = auth()->id();

        $avatar_image = $request->avatar;
        $avatar_image_new_name = time() . $avatar_image->getClientOriginalName();
        $avatar_image->move('uploads/users', $avatar_image_new_name);
        $manager->avatar = 'uploads/users/' . $avatar_image_new_name;
        $manager->assignRole('Manager');
        $manager->save();

        return redirect()->route('admin.managers.index')
            ->with('success', __('messages.ম্যানেজার সফলভাবে তৈরি করা হয়েছে।'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $manager)
    {
        return view('admin.manager.show', compact('manager'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $manager)
    {

        return view('admin.manager.edit', compact('manager'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $manager)
    {
        $request->validate([
            'name'  => 'required|string',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($manager)],
            'join_date'    => 'required|date',
            'phone'    => ['required','regex:/(01)[0-9]{9}/', 'min:11','max:11',Rule::unique('users', 'phone')->ignore($manager)],
            'nid'    => ['required','max:20', Rule::unique('users', 'nid')->ignore($manager)]
        ]);

        $manager->name = $request->name;
        $manager->join_date = $request->join_date;
        $manager->email = $request->email;
        $manager->phone = $request->phone;
        $manager->nid = $request->nid;
        $manager->education = $request->education;
        $manager->short_bio = $request->short_bio;
        $manager->address = $request->address;
        $manager->user_type = 1;
        $manager->updated_by = auth()->id();

        if (!empty($request->password)){
            $request->validate([
                'password' => 'required|min:8|confirmed',
                'password_confirmation'     => 'required',
            ]);
            $manager->password = Hash::make($request->password);
        }

        if(request()->hasFile('avatar') && request('avatar') != ''){
            $imagePath = public_path($manager->avatar);

            if(File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $avatar_image = $request->avatar;
            $avatar_image_new_name = time() . $avatar_image->getClientOriginalName();
            $avatar_image->move('uploads/users', $avatar_image_new_name);
            $manager->avatar = 'uploads/users/' . $avatar_image_new_name;
        }
        $manager->update();
        $manager->assignRole('Manager');

        return redirect()->back()->with('success', __('messages.ম্যানেজার সফলভাবে আপডেট করা হয়েছে।'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $manager)
    {
        $imagePath = public_path($manager->avatar);

        if(File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $manager->delete();

        return redirect()->back()->with('success', __('messages.ম্যানেজার সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
