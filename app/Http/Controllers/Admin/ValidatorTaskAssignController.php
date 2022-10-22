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
use App\Models\ValidatorTaskAssign;
class ValidatorTaskAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskAssigns=ValidatorTaskAssign::all();
        return view('admin.validator_task_assign.index',compact(('taskAssigns')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $languages = Language::pluck('name', 'id');
        $districts = District::pluck('name', 'id');
        $collectors= User::where('user_type', 6)->pluck('name', 'id');

        return view('admin.validator_task_assign.create', compact('languages','collectors','districts'));
    }

    public function getValidatorUpazila(Request $request){

        $upazilas = Upazila::where('district_id', $request->district_id)->pluck('name', 'id');

        return response()->json($upazilas);

    }


    public function getValidatorUnion(Request $request){

        $unions = Union::where('upazila_id', $request->upazila_id)->pluck('name', 'id');

        return response()->json($unions);

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
        $taskAssign = new ValidatorTaskAssign();
        $taskAssign->user_id = $request->user_id;
        $taskAssign->language_id =$request->language_id;
        $taskAssign->district_id =$request->district;
        $taskAssign->upazila_id =$request->upazila;
        $taskAssign->union_id =$request->union;
        $taskAssign->address =$request->address;
        $taskAssign->created_by =auth()->id();
        $taskAssign->updated_by =0;
        $taskAssign->save();


        return redirect()->route('admin.validator_task_assigns.index')
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
        $taskAssign = ValidatorTaskAssign::findOrFail($id);
        $taskAssign->delete();
        // Language::where('language_id', $id )->delete();
        // SubLanguage::where('sub_language_id', $id)->delete();
        return redirect()->back()->with('success', __('messages.টাস্ক অ্যাসাইন সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
