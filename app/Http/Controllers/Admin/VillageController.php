<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVillageRequest;
use App\Models\Union;
use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $villages=Village::latest()->get();

        return view('admin.village.index', compact('villages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unions=Union::all();

        return view('admin.village.create', compact('unions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVillageRequest $request)
    {
        Village::create([
            'name'=>$request->name,
            'union_id'=>$request->union_id,
            'created_by'=> auth()->id(),
            'updated_by'=> 0,

        ]);

        return redirect()->route('admin.villages.index')
            ->with('success', 'Village has been Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function show(Village $village)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function edit(Village $village)
    {
        $unions =Union::all();

        return view('admin.village.edit',compact('village', 'unions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVillageRequest $request, Village $village)
    {
        $village->update([
            'name'=>$request->name,
            'union_id'=>$request->union_id,
            'updated_by'=> auth()->id(),
        ]);
        return redirect()->back()
            ->with('success', 'Village has been Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function destroy(Village $village)
    {
        $village->delete();
        return redirect()->back()
            ->with('success', 'Village has been Deleted Successfully');
    }
}
