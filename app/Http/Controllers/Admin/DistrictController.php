<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDistricRequest;
use App\Http\Requests\UpdateDistrictRequest;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts =District::latest()->get();

        return view('admin.district.index', compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.district.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDistricRequest $request)
    {
        District::create($request->validated());

        return redirect()->route('admin.districts.index')
            ->with('success', __('messages.জেলা সফলভাবে তৈরি করা হয়েছে।'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        return view('admin.district.edit', compact('district'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDistrictRequest $request, District $district)
    {
        $district->update($request->validated());
        return redirect()->back()->with('success', __('messages.জেলা সফলভাবে আপডেট করা হয়েছে।'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        $district->delete();
        return redirect()->back()->with('success', __('messages.জেলা সফলভাবে মুছে ফেলা হয়েছে।'));

    }
}
