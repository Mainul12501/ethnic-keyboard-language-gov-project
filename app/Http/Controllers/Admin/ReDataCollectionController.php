<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DCSpontaneous;
use App\Models\DCDirectedSentence;
use App\Models\AudioTrim;
use App\Models\District;
use App\Models\DirectedTaskAssign;
use App\Models\DataCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReDataCollectionController extends Controller
{
    public function getTopicWiseReDataCollection($TaskID, $topicID,$directedID){

        $directedLanguages =DirectedTaskAssign::where('user_id', auth()->id())
             ->where('task_assign_id', $TaskID)
             ->where('topic_id', $topicID)
            //  ->where('taskAssign.topic.directeds.id',$directedID)
             ->with(['collector','taskAssign.speakers','taskAssign.language','taskAssign.district','topic.directeds'=>function($q)use($topicID, $directedID){
                $q->where('id', $directedID);
                $q->where('topic_id', $topicID);
             }])
             ->first();
         $districts = District::pluck('name', 'id');
         $sentence = $directedLanguages->topic->directeds->paginate(1);
         $languageBySpeakers= DB::table('language_districts')
              ->join('speakers', 'language_districts.id', '=', 'speakers.language_district_id')
              ->join('districts', 'language_districts.district_id', '=' , 'districts.id')
              ->where('language_id',$directedLanguages->taskAssign->language->id)
              ->select('language_districts.*','speakers.id as speaker_id','speakers.name as speaker_name','districts.name as district_name')
              ->get();
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
        $directedCollections=DataCollection::where('task_assign_id', $TaskID)
             ->where('type_id',1)
             ->with('dcDirected.dcSentence.directed')
             ->whereHas('dcDirected', function($q) use($topicID){
                 $q->where('topic_id', $topicID);
             })
             ->get();
         $sentenceList = $directedLanguages->topic->directeds;

         return view('admin.user_wise_data_collection.revertedDirectedCollection',compact('sentenceList','districts','sentence','directedAudios','directedCollections','directedLanguages', 'data','languageBySpeakers'));
     }
}
