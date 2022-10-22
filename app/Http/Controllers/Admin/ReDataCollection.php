<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\DirectedTaskAssign;
use App\Http\Controllers\Admin\District;
use App\Http\Controllers\Admin\DataCollection;
use Illuminate\Http\Request;

class ReDataCollection extends Controller
{
    public function getTopicWiseDataCollection($TaskID, $topicID){


        $directedLanguages =DirectedTaskAssign::where('user_id', auth()->id())
             ->where('task_assign_id', $TaskID)
             ->where('topic_id', $topicID)
             ->with('collector','taskAssign.speakers','taskAssign.language','taskAssign.district', 'topic.directeds')
             ->first();
         $districts = District::pluck('name', 'id');
         $sentence = $directedLanguages->topic->directeds->paginate(1);
         $languageBySpeakers= DB::table('language_districts')
              ->join('speakers', 'language_districts.id', '=', 'speakers.language_district_id')
              ->join('districts', 'language_districts.district_id', '=' , 'districts.id')
              ->where('language_id',$directedLanguages->taskAssign->language->id)
              ->select('language_districts.*','speakers.id as speaker_id','speakers.name as speaker_name','districts.name as district_name')
              ->get();
             //  dd($directedLanguages);

             //  ->where('language_id', $request->language_id)
             // ->where('user_id', auth()->id())
             //  ->with('language')->first();
             //  ->pluck('name', 'id');



         $data = [
             "task_assign_id" => $directedLanguages->task_assign_id,
             "district_id"    => $directedLanguages->taskAssign->district_id,
             "language_id"    => $directedLanguages->taskAssign->language_id,
         ];

         foreach($sentence as $sentenceItem){
             $directedID= $sentenceItem->id;
             $directedAudios=DataCollection::where('task_assign_id', $TaskID)
             ->where('type_id',1)
             ->with('speaker','dcDirected.dcSentence.directed')
             ->whereHas('dcDirected', function($q) use($topicID){
                 $q->where('topic_id', $topicID);
             })
             ->whereHas('dcDirected.dcSentence', function($q1) use($directedID){
                 $q1->where('directed_id', $directedID);
             })
             ->get();
         }



             // $sentenceWiseList=$directedAudios->topic->collection->dcDirect->audio;
        $directedCollections=DataCollection::where('task_assign_id', $TaskID)
             ->where('type_id',1)
             ->with('dcDirected.dcSentence.directed')
             ->whereHas('dcDirected', function($q) use($topicID){
                 $q->where('topic_id', $topicID);
             })
             ->get();

         $sentenceList = $directedLanguages->topic->directeds;

         return view('admin.data_collection.data_collect_directed',compact('sentenceList','districts','sentence','directedAudios','directedCollections','directedLanguages', 'data','languageBySpeakers'));
     }
}
