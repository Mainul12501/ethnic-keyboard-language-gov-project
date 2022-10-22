<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DCSpontaneous;
use App\Models\Directed;
use App\Models\DirectedTaskAssign;
use App\Models\District;
use App\Models\GroupCollectors;
use App\Models\SpontaneousTaskAssign;
use App\Models\TaskAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class TaskAssignController extends Controller
{
    public function index()
    {
        try {

            $languages=[];
            $tasks = TaskAssign::where('user_id', Auth::id())
                ->with('language','district')->get();

            if ($tasks->isNotEmpty()){
                $languages=$tasks;
            }

            if (count($languages)< 1){
                return response([
                    'task_assign_language'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'task_assign_language' => $languages,
                'message' => 'Task assign language List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'task_assign_language'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
    }



    public function getTaskDirectedLanguageTopic( $id, $district){
        try {

            $district = District::where('name', $district)->first();

            $districtID = TaskAssign::where('user_id', auth()->id())
                ->where('language_id', $id)
                ->where('district_id', $district->id)
                ->first();

            $taskDirectedLanguageTopics =DirectedTaskAssign::where('user_id', auth()->id())
                ->with('taskAssign.language', 'taskAssign.district', 'topic')
                ->whereHas('taskAssign', function ($q) use ( $id , $districtID){
                    return $q->where('language_id',$id)
                        ->where('district_id', $districtID->district_id);
                })->get();

            if ($taskDirectedLanguageTopics->isEmpty()){
                return response([
                    'task_directed_language_topic'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'task_directed_language_topic' => $taskDirectedLanguageTopics,
                'message' => 'Task Assign Directed Topic List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'task_directed_language_topic'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
    }

    public function getTaskDirectedLanguageTopicBySentence($id){
        try {

            $taskDirectedTopicSentences =Directed::where('topic_id', $id)->get();

            if ($taskDirectedTopicSentences->isEmpty()){
                return response([
                    'task_directed_language_topic_sentence'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'task_directed_language_topic_sentence' => $taskDirectedTopicSentences,
                'message' => 'Task Assign Directed Topic By Sentence List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'task_directed_language_topic_sentence'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
    }


    public function getSpontaneousLanguageByWordList($id, $district){
        try {

            $district = District::where('name', $district)->first();

            $districtID = TaskAssign::where('user_id', auth()->id())
                ->where('language_id', $id)
                ->where('district_id', $district->id)
                ->first();

             $taskDirectedSpontaneouses =SpontaneousTaskAssign::where('user_id', auth()->id())
                ->with('taskAssign.language', 'spontaneous')
                ->whereHas('taskAssign', function ($q) use ($id, $districtID){
                    return $q->where('language_id', $id)
                        ->where('district_id', $districtID->district_id);
                })->get();

            if ($taskDirectedSpontaneouses->isEmpty()){
                return response([
                    'task_spontaneous_word'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'task_spontaneous_word' => $taskDirectedSpontaneouses,
                'message' => 'Task Assign Spontaneous List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'task_spontaneous_word'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
    }



}
