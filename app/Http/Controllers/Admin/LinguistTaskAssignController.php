<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Upazila;
use App\Models\Union;
use App\Models\Language;
use App\Models\SubLanguage;
use App\Models\User;
use App\Models\LinguistTaskAssign;

class LinguistTaskAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskAssigns=LinguistTaskAssign::all();
        return view('admin.linguist_task_assign.index',compact(('taskAssigns')));
    }

    public function getSubLanguage(Request $request){

        $subLanguages = SubLanguage::where('language_id', $request->language_id)->pluck('sub_name', 'id');
// dd($subLanguages);
        return response()->json($subLanguages);

    }
    public function getLinguistUpazila(Request $request){

        $upazilas = Upazila::where('district_id', $request->district_id)->pluck('name', 'id');

        return response()->json($upazilas);

    }


    public function getLinguistUnion(Request $request){

        $unions = Union::where('upazila_id', $request->upazila_id)->pluck('name', 'id');

        return response()->json($unions);

    }

    public function create()
    {
        $languages = Language::pluck('name', 'id');
        $sublanguages = SubLanguage::pluck('sub_name', 'id');
        $districts = District::pluck('name', 'id');
        $collectors= User::where('user_type', 5)->pluck('name', 'id');

        return view('admin.linguist_task_assign.create', compact('languages','sublanguages','collectors','districts'));
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
            'user_id'  => 'required',
            'language_id'  => 'required',
        ]);
        $taskAssign = new LinguistTaskAssign();
        $taskAssign->user_id = $request->user_id;
        $taskAssign->language_id =$request->language_id;
        $taskAssign->sub_language_id =$request->sub_language_id;
        $taskAssign->district_id =$request->district;
        $taskAssign->upazila_id =$request->upazila;
        $taskAssign->union_id =$request->union;
        $taskAssign->address =$request->address;
        $taskAssign->created_by =auth()->id();
        $taskAssign->updated_by =0;
        $taskAssign->save();


        return redirect()->route('admin.linguist_task_assigns.index')
        ->with('success', __('messages.টাস্ক অ্যাসাইন সফলভাবে আপডেট করা হয়েছে।'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $taskAssign = LinguistTaskAssign::findOrFail($id);
        $taskAssign->delete();
        // Language::where('language_id', $id )->delete();
        // SubLanguage::where('sub_language_id', $id)->delete();
        return redirect()->back()->with('success', __('messages.টাস্ক অ্যাসাইন সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
