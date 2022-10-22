<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroupRequest;
use App\Models\Group;
use App\Models\GroupCollectors;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $groups= Group::with('collectors')->latest()->get();

//        return $groups;
        return view('admin.group.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $collectors= User::where('user_type', '4')->pluck('name', 'id');
        $managers = User::where('user_type', '1')->pluck('name', 'id');
        $supervisors = User::where('user_type', '2')->pluck('name', 'id');
        $guides = User::where('user_type', '3')->pluck('name', 'id');

        return view('admin.group.create', compact('collectors', 'managers', 'supervisors', 'guides'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest  $request)
    {
        $group= Group::create([
            'name'=>$request->name,
            'manager_id'=>$request->manager,
            // 'supervisor_id'=>$request->supervisor,
            // 'guide_id'=>$request->guide,
            'created_by'=>auth()->id(),
            'updated_by' => 0,
        ]);

        foreach ($request->get('member') as $memberItem){
            $member = new GroupCollectors();
            $member->group_id= $group->id;
            $member->user_id= $memberItem;
            $member->created_by = auth()->id();
            $member->updated_by = 0;
            $member->save();
        }

        return redirect()->route('admin.groups.index')
            ->with('success', __('messages.গ্রুপ সফলভাবে তৈরি করা হয়েছে।'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $group =Group::with('collectors')->first();
//        return $group;
//        $groupMembers= GroupCollectors::w
        return view('admin.group.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $collectors= User::where('user_type', '4')->pluck('name', 'id');
        $groupMembers= GroupCollectors::where('group_id', $group->id)->pluck('user_id', 'user_id')->toArray();
        $managers = User::where('user_type', '1')->pluck('name', 'id');
        $supervisors = User::where('user_type', '2')->pluck('name', 'id');
        $guides = User::where('user_type', '3')->pluck('name', 'id');

        return view('admin.group.edit',compact('group', 'collectors', 'groupMembers', 'managers', 'supervisors', 'guides'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGroupRequest $request, Group $group)
    {
        $group->update([
            'name'=>$request->name,
            'manager_id'=>$request->manager,
            'supervisor_id'=>$request->supervisor,
            'guide_id'=>$request->guide,
            'updated_by' => auth()->id(),
        ]);


        $groupMemberArray =[];
        $groupMemberIDs = GroupCollectors::where('group_id',$group->id)->get();
        if ($groupMemberIDs){
            foreach ($groupMemberIDs as $data){
                $groupMemberArray[]= $data->user_id;
            }
        }

        foreach ($request->member as $item){
            $data = array(
                'group_id' => $group->id,
                'user_id'=>$item,
                'created_by'=>auth()->id(),
                'updated_by'=>auth()->id()

            );
            GroupCollectors::updateOrCreate([
                'group_id' => $group->id,
                'user_id'=>$item,
            ],$data);
        }

        foreach ($groupMemberArray as $groupMember){
            if (!in_array($groupMember, $request->member)){
                GroupCollectors::where('group_id',$group->id)->where('user_id', $groupMember)->delete();
            }
        }

        return redirect()->back()
            ->with('success', __('messages.গ্রুপ সফলভাবে আপডেট করা হয়েছে।'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        GroupCollectors::where('group_id', $group->id)->delete();

        return redirect()->back()->with('success', __('গ্রুপ সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
