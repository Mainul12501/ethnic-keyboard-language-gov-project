<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataCollection;
use App\Models\DCDirected;
use App\Models\DCDirectedSentence;
use App\Models\DCSpontaneous;
use App\Models\Directed;
use App\Models\District;
use App\Models\Language;
use App\Models\Speaker;
use App\Models\Spontaneous;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DataCollectionController extends Controller
{

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'language_id' => 'required',
                'type_id'  => 'required',
                'audio' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'message'=>'Validator Error',
                    'data'=>$validator->errors(),
                    'status'=>422
                ]);
            }

            if ($request->speaker_id == null) {

                $speaker = $this->speaker($request);
            }

            $dataCollection = $this->dataCollection($request, ($request->speaker_id == null) ? $speaker->id : $request->speaker_id);

            $audio_src  = file_get_contents( $request->file('audio'));
            $audio_blob = base64_encode( $audio_src);

            if ($request->type_id == 1) {
                $dcDirect = $this->dcDirect($dataCollection, $request);
                $dcDirectSentence = $this->dcDirectSentence($request, $dcDirect,$audio_blob);
            } else {
                $dcSpont = $this->dcSpont($request, $dataCollection, $audio_blob);
            }


            return response()->json([
                'data'=> $dataCollection,
                'message'=> 'Data collection has been created Successfully',
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


    protected function speaker ($request)
    {
        $speaker = new Speaker();
        $speaker->name      = $request->name;
        $speaker->age      = $request->age;
        $speaker->occupation      = $request->occupation;
        $speaker->gender      = $request->gender;
        $speaker->image      = $this->imageUpload($request);
        $speaker->save();
        return $speaker;
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

    protected function audioUpload ($request)
    {
        if($request->hasFile('audio')){
            $image      =   $request->file('audio');
            $imageName  =   time().'.'.$image->getClientOriginalExtension();
            $directory  =   './uploads/data-collections/';
            $imageUrl   =   $directory.$imageName;
            $file = $image->move($directory, $imageName);
            return $imageUrl;
        }
    }

    protected function dataCollection ($request, $speaker)
    {
        $dataCollection = new DataCollection();
        $dataCollection->type_id = $request->type_id == '1' ? 1 : 2;
        $dataCollection->task_assign_id = $request->task_assign_id;
        $dataCollection->language_id = $request->language_id;
        $dataCollection->district_id = $request->district_id;
        $dataCollection->longitude  = $request->longitude;
        $dataCollection->latitude  = $request->latitude;
        $dataCollection->collector_id  = Auth::id();
        $dataCollection->speaker_id  = $speaker;
        $dataCollection->created_by  = Auth::id();
        $dataCollection->updated_by  = 0;
        $dataCollection->save();
        return $dataCollection;
    }


    protected function dcDirect ($dataCollection, $request)
    {
        $dcDirect = new DCDirected();
        $dcDirect->data_collection_id = $dataCollection->id;
        $dcDirect->topic_id = $request->topic_id;
        $dcDirect->created_by = Auth::id();
        $dcDirect->updated_by = 0;
        $dcDirect->save();
        return $dcDirect;
    }

    protected function dcDirectSentence ($request, $dcDirect, $audio_blob)
    {
        $dcDirectSentence = new DCDirectedSentence();
        $dcDirectSentence->audio = $request->hasFile('audio') ? $this->audioUpload($request) : '';
        $dcDirectSentence->audio_blob = $audio_blob;
        $dcDirectSentence->d_c_directed_id  = $dcDirect->id;
        $dcDirectSentence->directed_id   = $request->directed_id;
        $dcDirectSentence->approved_date   = Carbon::today()->toDateTimeString();
        $dcDirectSentence->created_by   = Auth::id();
        $dcDirectSentence->updated_by   = 0;
        $dcDirectSentence->save();
        return $dcDirectSentence;
    }

    protected function dcSpont ($request, $dataCollection, $audio_blob)
    {
        $dcSpont = new DCSpontaneous();
        $dcSpont->data_collection_id = $dataCollection->id;
        $dcSpont->audio = $request->hasFile('audio') ? $this->audioUpload($request) : '';
        $dcSpont->audio_blob = $audio_blob;
        $dcSpont->spontaneous_id = $request->spontaneous_id;
        $dcSpont->approved_date = Carbon::today()->toDateTimeString();
        $dcSpont->created_by = Auth::id();
        $dcSpont->updated_by = 0;
        $dcSpont->save();
        return $dcSpont;
    }


    public function getSpontaneousAudio($word, $taskAssignID, $language, $district ){
        try {
            $spontaneous =Spontaneous::where('word', $word)->first();
            $language = Language::where('name', $language)->first();
            $district = District::where('name', $district)->first();

            $status = DCSpontaneous::where('spontaneous_id', $spontaneous->id)->with('collection')
                ->whereHas('collection', function ($q) use ($taskAssignID, $language, $district){
                    return $q->where('task_assign_id', $taskAssignID)
                        ->where('language_id', $language->id)
                        ->where('district_id', $district->id);
                })->first();

            /*if ($status->isEmpty()){
                return response([
                    'task_spontaneous_audio'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }*/

            if (!empty($status))
            {
                return response([
                    'task_spontaneous_audio' => $status,
                    'message' => 'Task Assign Spontaneous Audio',
                    'status' => 200
                ]);
            } else {
                return response([
                    'task_spontaneous_audio'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }
            /*return response([
                'task_spontaneous_audio' => $status,
                'message' => 'Task Assign Spontaneous Audio',
                'status' => 200
            ]);*/

        }catch (\Exception $e){
            return response([
                'task_spontaneous_audio'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
    }




}
