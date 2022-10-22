<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\LanguageDistrict;
use App\Models\Speaker;
use App\Models\Union;
use App\Models\Upazila;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpeakerController extends Controller
{

    public function index()
    {
        try {

            $speakers = Speaker::latest()->paginate(10);

            if ($speakers->isEmpty()){
                return response([
                    'speaker'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'speaker' => $speakers,
                'message' => 'Task assign language List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'speaker'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
    }

    public function getSpeakers($languageID){

        try {
            $languageDistrictIDs=LanguageDistrict::where('language_id', $languageID)->pluck('id');

            $speakers= Speaker::whereIn('language_district_id', $languageDistrictIDs)->paginate(10);
            if ($speakers->isEmpty()){
                return response([
                    'speaker'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'speaker' => $speakers,
                'message' => 'Speaker List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'speaker'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }

    }

    public function store(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'name'      => 'required|string',
                'gender'    => 'required',
    //            'phone' => 'required|regex:/(01)[0-9]{9}/|min:11|max:11|unique:speakers',
            ]);
            $languageDistrict=LanguageDistrict::where('language_id',$request->language_id)
            ->where('district_id',$request->district_id)
            ->first();

            if($validator->fails()){
                return response()->json([
                    'message'=>'Validator Error',
                    'data'=>$validator->errors(),
                    'status'=>422
                ]);
            }

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

            return response()->json([
                'data'=> $speaker,
                'message'=> 'Speaker has been created Successfully',
                'status'=> 200
            ]);


        }catch (\Exception $e){
            return response([
                'data'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
    }

    protected function imageUpload ($request)
    {
        if($request->hasFile('image')){
            $image      =   $request->file('image');
            $imageName  =   time().'.'.$image->getClientOriginalExtension();
            $directory  =   './uploads/speakers/';
            $imageUrl   =   $directory.$imageName;
            $file = $image->move($directory, $imageName);
            return $imageUrl;
        }
    }


    public function getDistricts(){
        try {

            $districts = District::all();

            if ($districts->isEmpty()){
                return response([
                    'districts'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'districts' => $districts,
                'message' => 'Districts  List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'districts'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
    }


    public function getUpazila($id){
        try {

            $upazilas = Upazila::where('district_id', $id)->get();

            if ($upazilas->isEmpty()){
                return response([
                    'upazilas'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'upazilas' => $upazilas,
                'message' => 'Upazila  List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'upazilas'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }


    }


    public function getUnion($id){

        try {

            $unions = Union::where('upazila_id', $id)->get();


            if ($unions->isEmpty()){
                return response([
                    'unions'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'unions' => $unions,
                'message' => 'Union  List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'unions'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }

    }

    public function getVillage($id){

        try {

            $villages= Village::where('union_id', $id)->get();


            if ($villages->isEmpty()){
                return response([
                    'villages'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'villages' => $villages,
                'message' => 'Village  List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'villages'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
    }


}
