<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataCollection;
use App\Models\Directed;
use App\Models\DirectedLanguage;
use App\Models\DirectedTaskAssign;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DirectedLanguageController extends Controller
{

    public function getDirectedLanguageList($id){
        $directedLanguages=DirectedLanguage::with('topics', 'language')->where('language_id', $id)->get();

        $firstItem = Arr::first($directedLanguages, function ($value, $key) {
            return $value;
        });

        return view('admin.directed_language.index', compact('directedLanguages', 'firstItem'));
    }

    public function getDirectedTopicList($id){
        $directedLanguages=DirectedLanguage::with('topics', 'language')->where('language_id', $id)->get();

        $firstItem = Arr::first($directedLanguages, function ($value, $key) {
            return $value;
        });

        return view('admin.directed_language.topicList', compact('directedLanguages', 'firstItem'));
    }

    public function getTopicBySentence($taskAssignID, $topicID){
           $directedTaskByTopic=DirectedTaskAssign::with('taskAssign.language', 'taskAssign.district', 'topic.directeds','taskAssign.collections.dcDirected.dcSentence')
            ->where('task_assign_id', $taskAssignID)
            ->where('topic_id', $topicID)
            // ->get()
            // ->toArray();
            ->first();
         $directedSentences =$directedTaskByTopic->topic->directeds;
        $collectorID=$directedTaskByTopic->taskAssign->user_id;
        // return$directedSentences =$directedTaskByTopic->taskAssign->collections->groupBy('task_assign_id')->count();
        // foreach($directedSentences as $key=>$audio)
        // {
        //     return$r=$audio->dcDirected->dcSentence->count('audio_duration');
        // }
//        $sentences= Directed::with('topics')->where('topic_id', $id)->get();
        /*return $firstItem = Arr::first($directedTaskByTopic, function ($value, $key) {
            return $value;
        });*/
        return view('admin.directed_language.sentenceList', compact('directedSentences', 'directedTaskByTopic', 'collectorID'));

    }

    public function topicBySentenceList($topicID , $languageID){

        $sentences= Directed::with('topics')->where('topic_id', $topicID)->get();


        $firstItem = Arr::first($sentences, function ($value, $key) {
            return $value;
        });
        $language=DirectedLanguage::with( 'language')
            ->where('topic_id', $topicID)
            ->where('language_id', $languageID)
            ->first();

        return view('admin.directed_language.sentences', compact('sentences', 'firstItem', 'language'));
    }

}
