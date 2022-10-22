<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaffGroupRequest;
use App\Models\DataCollector;
use App\Models\StaffGroup;
use App\Models\StaffGroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $staffGroups= StaffGroup::with('dataCollectors')->latest()->paginate(3);

        return view('admin.group.index', compact('staffGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataCollectors= DataCollector::all();

        return view('admin.group.create', compact('dataCollectors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStaffGroupRequest $request)
    {

        $staffGroup=StaffGroup::create($request->validated());

        foreach ($request->get('member') as $memberItem){
            $member = new StaffGroupMember;
            $member->staff_group_id= $staffGroup->id;
            $member->data_collector_id= $memberItem;
            $member->save();
        }

        return redirect()->route('admin.staff_groups.index')
            ->with('success', 'Staff Group has been created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaffGroup  $staffGroup
     * @return \Illuminate\Http\Response
     */
    public function show(StaffGroup $staffGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffGroup  $staffGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffGroup $staffGroup)
    {
        $dataCollectors= DataCollector::get(['id', 'name']);
        $staffGroupMembers= StaffGroupMember::where('staff_group_id', $staffGroup->id)->get();
        $managers =['1'=>"আরিফুল", '2'=>'সুমন', '3'=>'রহিম'];
        $supervisors =['1'=>"আরিফুল", '2'=>'সুমন', '3'=>'রহিম'];
        $guides =['1'=>"আরিফুল", '2'=>'সুমন', '3'=>'রহিম'];

        return  view('admin.group.edit', compact('staffGroup', 'dataCollectors', 'staffGroupMembers', 'guides','managers', 'supervisors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffGroup  $staffGroup
     * @return \Illuminate\Http\Response
     */
    public function update(StoreStaffGroupRequest $request, StaffGroup $staffGroup)
    {
        $staffGroup->update($request->validated());

        $ids = StaffGroupMember::where('staff_group_id',$staffGroup->id)->get(['id'])->toArray();
        $data = $request->member;

        for ($i = 0; $i <count($ids); $i++) {
            StaffGroupMember::where(['id' => $ids[$i]['id']])
                ->update(['data_collector_id' => $data[$i]]);
        }


        return redirect()->back()
            ->with('success', 'Staff Group has been updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaffGroup  $staffGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffGroup $staffGroup)
    {
        $staffGroup->delete();
        StaffGroupMember::where('staff_group_id', $staffGroup->id)->delete();

        return redirect()->back()->with('success', 'Staff Group has been deleted Successfully');
    }
}
