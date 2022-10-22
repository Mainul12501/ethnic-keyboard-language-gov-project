<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSpeakerRequest;
use App\Http\Requests\UpdateSpeakerRequest;
use App\Models\Directed;
use App\Models\District;
use App\Models\Speaker;
use App\Models\TaskAssign;
use App\Models\Language;
use App\Models\LanguageDistrict;
use App\Models\Topic;
use App\Models\Union;
use App\Models\Upazila;
use App\Models\Village;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $speakers = Speaker::latest()->paginate(5);
       $tasks = TaskAssign::where('user_id', Auth::id())->groupBy('district_id')
       ->with('language','district')->get();
        $districts = District::pluck('name', 'id');
        $languages = TaskAssign::with('language')->where('user_id', auth()->id())/* distinct('language_id') */->groupBy('language_id')->get();
        $speakers = Speaker::where('created_by', auth()->id())->latest()->paginate(5);
        return view('admin.speaker.index', compact('speakers','tasks','districts','languages'));
    }
    public function getLangDistrict(Request $request){

         $districts= DB::table('districts')
             ->join('language_districts', 'districts.id', '=', 'language_districts.district_id')
             ->where('language_id', $request->language_id)
             ->select('districts.*')
             ->pluck('name', 'id');

         return response()->json($districts);
     }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $tasks = TaskAssign::where('user_id', Auth::id())
        //     ->with('language','district')->get();
        // $languages = TaskAssign::with('language')->where('user_id', auth()->id())->distinct('language_id')->groupBy('language_id')->get();
        // $districts = District::pluck('name', 'id');

        $upazilas = Upazila::pluck('name', 'id');
        $unions = Union::pluck('name', 'id');

        return view('admin.speaker.create', compact('districts', 'upazilas', 'unions','tasks','languages','districts'));
    }

    public function createSpeaker($taskAssignID, Request $request){
//        $spontaneousID= $request->spontaneousID;
        return response()->json([
            'taskAssignID'=>$taskAssignID,
//            'spontaneousID'=>$spontaneousID,
        ], 200);
    }

    public function createValidator($taskAssignID, Request $request){
        return response()->json([
            'taskAssignID'=>$taskAssignID,
        ], 200);
    }

    public function validatorStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string',
            'gender'    => 'required',
        ]);

        if ($validator->passes()){
            $speaker = new Speaker();
            $speaker->language_district_id = $request->language_district_id;
            $speaker->name= $request->name;
            $speaker->type= 1;
            $speaker->age = $request->age;
            $speaker->occupation = $request->occupation;
            $speaker->gender = $request->gender;
            $speaker->email = $request->email;
            $speaker->phone = $request->phone;
            $speaker->education = $request->education;
            $speaker->address = $request->address;
            $speaker->district_id = $request->district_id;
            $speaker->upazila_id = $request->upazila_id;
            $speaker->union_id = $request->union_id;
            $speaker->area = $request->area;
            $speaker->created_by = auth()->id();
            $speaker->updated_by = 0;
            if ($request->hasFile('image')){
                $speaker->image      = $this->imageUpload($request);
            }
            $speaker->save();

            return redirect()->back()
                ->with('success', __('Validator has been Created Successfully'));
        }else{
            return redirect()->back()->withErrors($validator);
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string',
            'gender'    => 'required',
//            'phone' => 'required|regex:/(01)[0-9]{9}/|min:11|max:11|unique:speakers',
        ]);
        $languageDistrict=LanguageDistrict::where('language_id',$request->language_id)
        ->where('district_id',$request->district_id)
        ->first();

        if ($validator->passes()){
            $speaker = new Speaker();
            $speaker->language_district_id = $languageDistrict->id;
            $speaker->name= $request->name;
            $speaker->age = $request->age;
            $speaker->occupation = $request->occupation;
            $speaker->gender = $request->gender;
            $speaker->email = $request->email;
            $speaker->phone = $request->phone;
            $speaker->education = $request->education;
            $speaker->address = $request->address;
            $speaker->district_id = $request->district;
            $speaker->upazila_id = $request->upazila_id;
            $speaker->union_id = $request->union_id;
            $speaker->area = $request->area;
            $speaker->created_by = auth()->id();
            $speaker->updated_by = 0;
            if ($request->hasFile('image')){
                $speaker->image      = $this->imageUpload($request);
            }
            $speaker->save();

            return redirect()->back()
                ->with('success', __('Speaker has been Created Successfully'));
        }else{
            return redirect()->back()->withErrors($validator);// ['error'=>$validator->errors()->all()];
        }
    }

    protected function imageUpload ($request)
    {
        if($request->hasFile('image')){
            $image      =   $request->file('image');
            $imageName  =   time().'.'.$image->getClientOriginalExtension();
            $directory  =   'uploads/speakers/';
            $imageUrl   =   $directory.$imageName;
            $file = $image->move($directory, $imageName);
            return $imageUrl;
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function show(Speaker $speaker)
    {
        return view('admin.speaker.show', compact('speaker'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function edit(Speaker $speaker)
    {
        $districts = District::pluck('name', 'id');
        $upazilas = Upazila::where([
            ['district_id', '=', $speaker->district_id],
        ])->pluck('name', 'id');
        $unions = Union::where([
            ['upazila_id', '=', $speaker->upazila_id],
        ])->pluck('name', 'id');
        $genders =['0'=>"পুরুষ", '1'=>'মহিলা','2'=>'অন্যান্য'];

        return view('admin.speaker.edit',
            compact('speaker', 'districts', 'upazilas', 'unions','genders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpeakerRequest $request, Speaker $speaker)
    {
        $speaker->name= $request->name;
        // $speaker->language_district_id = $request->id;
        $speaker->age = $request->age;
        $speaker->occupation = $request->occupation;
        $speaker->gender = $request->gender;
        $speaker->email = $request->email;
        $speaker->phone = $request->phone;
        $speaker->education = $request->education;
        $speaker->address = $request->address;
        $speaker->district_id = $request->district_id;
        $speaker->upazila_id = $request->upazila_id;
        $speaker->union_id = $request->union_id;
        $speaker->area = $request->area;
        $speaker->updated_by = auth()->id();
        if(request()->hasFile('image') && request('image') != ''){
            $imagePath = public_path($speaker->image);

            if(File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $avatar_image = $request->image;
            $avatar_image_new_name = time() . $avatar_image->getClientOriginalExtension();
            $avatar_image->move('uploads/speakers', $avatar_image_new_name);
            $speaker->image = 'uploads/speakers/' . $avatar_image_new_name;
        }
        $speaker->update();

        return redirect()->route('admin.dashboard')->with('success', 'Speaker has been Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speaker $speaker)
    {
        $speaker->delete();

        return redirect()->back()->with('success', 'Speaker has been Deleted Successfully');
    }
}
