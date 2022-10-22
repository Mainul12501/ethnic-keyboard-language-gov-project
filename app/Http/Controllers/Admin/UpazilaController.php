<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpazilaRequest;
use App\Http\Requests\UpdateUpazilaRequest;
use App\Models\District;
use App\Models\Upazila;
use Illuminate\Http\Request;

class UpazilaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $upazilas =Upazila::latest()->get();

        return view('admin.upazila.index', compact('upazilas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts = District::all();

        return view('admin.upazila.create', compact('districts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpazilaRequest $request)
    {
        Upazila::create([
            'name'=>$request->name,
            'bn_name'=>$request->bn_name,
            'district_id'=>$request->district_id,
            'created_by'=> auth()->id(),
            'updated_by'=> 0,

        ]);

        return redirect()->route('admin.upazilas.index')
            ->with('success', __('messages.উপজেলা সফলভাবে তৈরি করা হয়েছে।'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Upazila  $upazila
     * @return \Illuminate\Http\Response
     */
    public function show(Upazila $upazila)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Upazila  $upazila
     * @return \Illuminate\Http\Response
     */
    public function edit(Upazila $upazila)
    {
        $districts = District::all();

        return view('admin.upazila.edit', compact('upazila', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Upazila  $upazila
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUpazilaRequest $request, Upazila $upazila)
    {
        $upazila->update([
            'name'=>$request->name,
            'bn_name'=>$request->bn_name,
            'district_id'=>$request->district_id,
            'updated_by'=>  auth()->id(),

        ]);

        return redirect()->back()->with('success', __('messages.উপজেলা সফলভাবে আপডেট করা হয়েছে।'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Upazila  $upazila
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upazila $upazila)
    {
        $upazila->delete();

        return redirect()->back()->with('success', __('messages.উপজেলা সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
