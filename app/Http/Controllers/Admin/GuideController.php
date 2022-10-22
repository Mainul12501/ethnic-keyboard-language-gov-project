<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataCollectorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use File;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guides = User::where('user_type', 3)->latest()->get();

        return view('admin.guide.index', compact('guides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.guide.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'email'     => 'required|email|unique:users',
            // 'join_date'    => 'required|date',
            // 'phone'    => 'required|regex:/(01)[0-9]{9}/|min:11|max:11|unique:users',
            // 'avatar'    => 'required|image|max:2048|c',
            // 'nid'      => 'required|unique:users',
        ]);

        $guide =new User();
        $guide->name = $request->name;
        $guide->join_date = $request->join_date;
        $guide->email = $request->email;
        $guide->phone = $request->phone;
        $guide->nid = $request->nid;
        $guide->education = $request->education;
        $guide->short_bio = $request->short_bio;
        $guide->address = $request->address;
        $guide->user_type = 3;
        $guide->created_by = auth()->id();

        $avatar_image = $request->avatar;
        $avatar_image_new_name = time() . $avatar_image->getClientOriginalName();
        $avatar_image->move('uploads/users', $avatar_image_new_name);
        $guide->avatar = 'uploads/users/' . $avatar_image_new_name;

        $guide->save();

        return redirect()->route('admin.guides.index')
            ->with('success', __('messages.গাইড সফলভাবে তৈরি করা হয়েছে।'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $guide)
    {
        return view('admin.guide.show', compact('guide'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $guide)
    {
        return view('admin.guide.edit', compact('guide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $guide)
    {
        $request->validate([
            'name'  => 'required|string',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($guide)],
            'join_date'    => 'required|date',
            'phone'    => ['required','regex:/(01)[0-9]{9}/', 'min:11','max:11',Rule::unique('users', 'phone')->ignore($guide)],
            'nid'    => ['required','max:20', Rule::unique('users', 'nid')->ignore($guide)],
        ]);

        $guide->name = $request->name;
        $guide->join_date = $request->join_date;
        $guide->email = $request->email;
        $guide->phone = $request->phone;
        $guide->nid = $request->nid;
        $guide->education = $request->education;
        $guide->short_bio = $request->short_bio;
        $guide->address = $request->address;
        $guide->user_type = 3;
        $guide->updated_by = auth()->id();

        if(request()->hasFile('avatar') && request('avatar') != ''){
            $imagePath = public_path($guide->avatar);

            if(File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $avatar_image = $request->avatar;
            $avatar_image_new_name = time() . $avatar_image->getClientOriginalName();
            $avatar_image->move('uploads/users', $avatar_image_new_name);
            $guide->avatar = 'uploads/users/' . $avatar_image_new_name;
        }
        $guide->update();

        return redirect()->back()->with('success', __('messages.গাইড সফলভাবে আপডেট করা হয়েছে।'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $guide)
    {
        $imagePath = public_path($guide->avatar);

        if(File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $guide->delete();

        return redirect()->back()->with('success', __('messages.গাইড সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
