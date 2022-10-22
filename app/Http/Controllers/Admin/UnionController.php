<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnionRequest;
use App\Http\Requests\UpdateUnionRequest;
use App\Models\Union;
use App\Models\Upazila;
use Illuminate\Http\Request;

class UnionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unions= Union::latest()->get();

        return view('admin.union.index', compact('unions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $upazilas =Upazila::all();

        return view('admin.union.create', compact('upazilas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnionRequest $request)
    {
        Union::create([
            'name'=>$request->name,
            'bn_name'=>$request->bn_name,
            'upazila_id'=>$request->upazila_id,
            'created_by'=> auth()->id(),
            'updated_by'=> 0,
        ]);

        return redirect()->route('admin.unions.index')
            ->with('success', __('messages.ইউনিয়ন সফলভাবে তৈরি করা হয়েছে।'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Union  $union
     * @return \Illuminate\Http\Response
     */
    public function show(Union $union)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Union  $union
     * @return \Illuminate\Http\Response
     */
    public function edit(Union $union)
    {
        $upazilas =Upazila::all();

        return view('admin.union.edit', compact('upazilas', 'union'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Union  $union
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnionRequest $request, Union $union)
    {
        $union->update([
            'name'=>$request->name,
            'bn_name'=>$request->bn_name,
            'upazila_id'=>$request->upazila_id,
            'updated_by'=> auth()->id(),
        ]);

        return redirect()->back()->with('success', __('messages.ইউনিয়ন সফলভাবে আপডেট করা হয়েছে।'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Union  $union
     * @return \Illuminate\Http\Response
     */
    public function destroy(Union $union)
    {
        $union->delete();
        return redirect()->back()->with('success', __('messages.ইউনিয়ন সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
