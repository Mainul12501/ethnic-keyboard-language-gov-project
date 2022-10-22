<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataCollectorRequest;
use App\Http\Requests\UpdateDataCollectorRequest;
use App\Models\DataCollection;
use App\Models\DCDirected;
use App\Models\DCDirectedSentence;
use App\Models\DCSpontaneous;
use App\Models\DirectedTaskAssign;
use App\Models\GroupCollectors;
use App\Models\SpontaneousTaskAssign;
use App\Models\TaskAssign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Session;
use File;

class DataCollectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCollectors = User::where('user_type', 4)->latest()->get();
//        return $dataCollectors;

        return view('admin.data_collector.index', compact('dataCollectors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $dataCollectorTypes = DataCollectorType::pluck('name', 'id');

        return view('admin.data_collector.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDataCollectorRequest $request)
    {

        $dataCollector =new User();
        $dataCollector->name = $request->name;
        $dataCollector->join_date = $request->join_date;
        $dataCollector->email = $request->email;
        $dataCollector->password = Hash::make($request->password);
        $dataCollector->phone = $request->phone;
        $dataCollector->nid = $request->nid;
        $dataCollector->education = $request->education;
        $dataCollector->short_bio = $request->short_bio;
        $dataCollector->address = $request->address;
        $dataCollector->user_type= 4;
        $dataCollector->created_by = auth()->id();

        $avatar_image = $request->avatar;
        $avatar_image_new_name = time() . $avatar_image->getClientOriginalName();
        $avatar_image->move('uploads/users', $avatar_image_new_name);
        $dataCollector->avatar = 'uploads/users/' . $avatar_image_new_name;
        $dataCollector->assignRole('Data Collector');

        $dataCollector->save();

        return redirect()->route('admin.data_collectors.index')
            ->with('success', __('messages.ডাটা কালেক্টর সফলভাবে তৈরি করা হয়েছে।'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataCollector  $dataCollector
     * @return \Illuminate\Http\Response
     */
    public function show(User $dataCollector)
    {
        return view('admin.data_collector.show', compact('dataCollector'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataCollector  $dataCollector
     * @return \Illuminate\Http\Response
     */
    public function edit(User $dataCollector)
    {
//        return $dataCollector;
        return view('admin.data_collector.edit', compact('dataCollector'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataCollector  $dataCollector
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $dataCollector)
    {

        $request->validate([
            'name'  => 'required|string',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($dataCollector)],
            'join_date'    => 'required|date',
            'phone'    => ['required','regex:/(01)[0-9]{9}/','min:11','max:11', Rule::unique('users', 'phone')->ignore($dataCollector)],
            'nid'    => ['required','max:20', Rule::unique('users', 'nid')->ignore($dataCollector)],
        ]);

        $dataCollector->name = $request->name;
        $dataCollector->join_date = $request->join_date;
        $dataCollector->email = $request->email;
        $dataCollector->phone = $request->phone;
        $dataCollector->nid = $request->nid;
        $dataCollector->education = $request->education;
        $dataCollector->short_bio = $request->short_bio;
        $dataCollector->address = $request->address;
        $dataCollector->user_type = 4;
        $dataCollector->updated_by = auth()->id();
        if (!empty($request->password)){
            $request->validate([
                'password' => 'required|min:8|confirmed',
                'password_confirmation'     => 'required',
            ]);
            $dataCollector->password = Hash::make($request->password);
        }

        if(request()->hasFile('avatar') && request('avatar') != ''){
            $imagePath = public_path($dataCollector->avatar);

            if(File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $avatar_image = $request->avatar;
            $avatar_image_new_name = time() . $avatar_image->getClientOriginalName();
            $avatar_image->move('uploads/users', $avatar_image_new_name);
            $dataCollector->avatar = 'uploads/users/' . $avatar_image_new_name;
        }
        $dataCollector->update();
        $dataCollector->assignRole('Data Collector');

        return redirect()->back()->with('success', __('messages.ডাটা কালেক্টর সফলভাবে আপডেট করা হয়েছে।'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $dataCollector
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $dataCollector)
    {
        /*if ($dataCollector->tasks()->count() && $dataCollector->groupCollectors()->count()){
            return back()->with(['error'=>'Cannot delete, Data Collector has Task and Group Records']);
        }
        if ($dataCollector->tasks()->count()){
            return back()->with(['error'=>'Cannot delete, Data Collector has Task Record']);
        }
        if ($dataCollector->groupCollectors()->count()){
            return back()->with(['error'=>'Cannot delete, Data Collector has Group Record']);
        }*/

        $imagePath = public_path($dataCollector->avatar);
        if(File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $dataCollector->delete();
        TaskAssign::where('user_id', $dataCollector->id)->delete();
        SpontaneousTaskAssign::where('user_id', $dataCollector->id)->delete();
        DirectedTaskAssign::where('user_id', $dataCollector->id)->delete();
        GroupCollectors::where('user_id', $dataCollector->id)->delete();
        $dataCollection =DataCollection::where('collector_id', $dataCollector->id)->first();
        if (!empty($dataCollection)){
            $dataCollection->delete();
            $dcDirected = DCDirected::where('data_collection_id', $dataCollection->id)->first();
            if (!empty($dcDirected)){
                $dcDirected->delete();
                $dcDirectedSentence = DCDirectedSentence::where('d_c_directed_id', $dcDirected->id)->first();
                $audioPath = public_path($dcDirectedSentence->audio);
                if(File::exists($audioPath)) {
                    File::delete($audioPath);
                }
                $dcDirectedSentence->delete();
            }else{

                $dcSpontaneous= DCSpontaneous::where('data_collection_id', $dataCollection->id)->first();
                $audioPath = public_path($dcSpontaneous->audio);
                if(File::exists($audioPath)) {
                    File::delete($audioPath);
                }
                $dcSpontaneous->delete();
            }
        }


        return redirect()->back()->with('success', __('messages.ডাটা কালেক্টর সফলভাবে মুছে ফেলা হয়েছে।'));
    }

}
