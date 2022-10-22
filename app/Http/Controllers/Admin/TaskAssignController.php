<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskAssignRequest;
use App\Http\Requests\UpdateTaskAssignRequest;
use App\Models\AudioTrim;
use App\Models\DataCollection;
use App\Models\DCDirected;
use App\Models\Directed;
use App\Models\DCDirectedSentence;
use App\Models\DCSpontaneous;
use App\Models\DirectedTaskAssign;
use App\Models\District;
use App\Models\Group;
use App\Models\Language;
use App\Models\SpontaneousTaskAssign;
use App\Models\SubLanguage;
use App\Models\TaskAssign;
use App\Models\Union;
use App\Models\Upazila;
use App\Models\User;
use App\Models\Village;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use File;

class TaskAssignController extends Controller
{

    public function taskAssignListByLanguage(){
        if(Auth::user()->hasRole(['Linguist','Validator' ,'Admin'])){
           /*  return */$taskAssignListByLanguages = TaskAssign::with(['language','district'])
                ->withCount( 'directedTasks', 'spontaneousTasks')
                ->latest()
                ->get();

        }elseif(Auth::user()->hasRole(['Data Collector','Manager' /* ,'Admin'*/])){
           /* return */$taskAssignListByLanguages= TaskAssign::with(['language','district','directedTasks.topic','spontaneousTasks.spontaneous'])
                // ->where('user_id', auth()->id() )
                ->withCount( 'directedTasks', 'spontaneousTasks')
                ->latest()
                ->get();
                // ->withCount('directedTasks')
                // ->count();
        }


        return view('admin.task_assign.taskAssignList', compact('taskAssignListByLanguages'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   


    public function getCollector(Request $request){
        $collectors= DB::table('users')
            ->join('group_collectors', 'users.id', '=', 'group_collectors.user_id')
            ->where('group_id', $request->group_id)
            ->select('users.*')
            ->pluck('name', 'id');
//        return $collectors;
        return $data= view('admin.task_assign.renderGroup',compact('collectors'))->render();
    }

    public function getGroupByCollector(Request $request){
        /*return Group::with(['assign','member'=>function($a){$a->with(['collectors']);}])
         //->whereHas('group',function ($a)use ($request){};))
            ->findOrFail($request->group_id);*/

        $collectors= DB::table('users')
            ->join('group_collectors', 'users.id', '=', 'group_collectors.user_id')
            ->where('group_id', $request->group_id)
            ->select('users.*')
            ->pluck('name', 'id');
        return response()->json($collectors);
    }

    public function getTaskUser(Request $request){
        $collectors = DB::table('users')
            ->join('group_collectors', 'users.id', '=', 'group_collectors.user_id')
            ->where('group_id', $request->group_id)
            ->select('users.*')
            ->pluck('name', 'id');
//        dd($collectors);
        return response()->json($collectors);
    }

    public function getDirectedTopic(Request $request){
        $topics= DB::table('topics')
            ->join('directed_languages', 'topics.id', '=', 'directed_languages.topic_id')
            ->where('language_id', $request->language_id)
            ->select('topics.*')
            ->pluck('name', 'id');

        return response()->json($topics);
    }

    public function getSpontaneous(Request $request){
        $spontaneouses= DB::table('spontaneouses')
            ->join('spontaneous_languages', 'spontaneouses.id', '=', 'spontaneous_languages.spontaneous_id')
            ->where('language_id', $request->language_id)
            ->select('spontaneouses.*')
            ->pluck('word', 'id');
        return response()->json($spontaneouses);
    }


    public function getUpazila(Request $request){

        $upazilas = Upazila::where('district_id', $request->district_id)->pluck('name', 'id');

        return response()->json($upazilas);

    }


    public function getUnion(Request $request){

        $unions = Union::where('upazila_id', $request->upazila_id)->pluck('name', 'id');

        return response()->json($unions);

    }

    public function getVillage(Request $request){
        $villages= Village::where('union_id', $request->union_id)->pluck('name', 'id');

        return response()->json($villages);
    }


    public function getDirectedByLanguage(){

    }


    public function getDirectedTaskByLanguage($id){

       $directedTaskLanguages=DirectedTaskAssign::where('task_assign_id', $id)
        ->with('taskAssign.collections.dcDirected.dcSentence.directed.topics' ,'taskAssign.directedTasks.topic')
        ->with(['taskAssign.directedTasks.topic'=>function ($query){
            $query->withCount('directeds');
        },])
           /* ->with(['taskAssign.collections'=>function($q){
                $q->with('dcDirected', function ($q){
                    $q->withSum('dcSentence', 'audio_duration');
                });
            }])*/

         ->get();

         // sum of audio duration by task assign id
            $sumAudioDuration= DB::table('data_collections')
            ->join('d_c_directeds', 'data_collections.id', '=', 'd_c_directeds.data_collection_id')
            ->join('d_c_directed_sentences', 'd_c_directeds.id', '=', 'd_c_directed_sentences.d_c_directed_id')
            ->where('data_collections.task_assign_id', $id)
            ->sum('d_c_directed_sentences.audio_duration');
//        dd($sumAudioDuration);
            $sumSpontTrimAudioDuration= DB::table('data_collections')
            ->join('d_c_spontaneouses', 'data_collections.id', '=', 'd_c_spontaneouses.data_collection_id')
            // ->join('audio_trims', 'd_c_spontaneouses.id', '=', 'audio_trims.d_c_spontaneouses_id')
            ->where('data_collections.task_assign_id', $id)
            ->sum('d_c_spontaneouses.audio_duration');
            $total=$sumAudioDuration+$sumSpontTrimAudioDuration;

            $collected_time= number_format((float)$total, 2, '.', '');
           $taskAssignByLanguage= TaskAssign::with(['directedTasks.topic'=>function ($query){
                $query->withCount('directeds');

            }, 'spontaneousTasks.spontaneous','language.subLanguages',
                'district','upazila', 'union', 'collections.speaker', 'collections.dcSpontaneous.spontaneous', 'collections.dcDirected.dcSentence.directed.topics'])
                ->where('user_id', auth()->id() )
                ->withCount( 'directedTasks', 'spontaneousTasks')
                ->latest()
                ->get();

        $firstItem = Arr::first($directedTaskLanguages, function ($value, $key) {
            return $value;
        });

        return view('admin.task_assign.directedList', compact('directedTaskLanguages','taskAssignByLanguage','sumAudioDuration','collected_time', 'firstItem'));
    }

    public function getSpontaneousTaskByLanguage($id){
        $spontaneousTaskLanguages=SpontaneousTaskAssign::with('taskAssign.language', 'taskAssign.district', 'spontaneous')
        ->where('task_assign_id', $id)
        ->get();
        // sum of audio duration by task assign id
        $sumAudioDuration= DB::table('data_collections')
        ->join('d_c_directeds', 'data_collections.id', '=', 'd_c_directeds.data_collection_id')
        ->join('d_c_directed_sentences', 'd_c_directeds.id', '=', 'd_c_directed_sentences.d_c_directed_id')
        ->where('data_collections.task_assign_id', $id)
        ->sum('d_c_directed_sentences.audio_duration');
        //        dd($sumAudioDuration);
        $sumSpontTrimAudioDuration= DB::table('data_collections')
        ->join('d_c_spontaneouses', 'data_collections.id', '=', 'd_c_spontaneouses.data_collection_id')
        // ->join('audio_trims', 'd_c_spontaneouses.id', '=', 'audio_trims.d_c_spontaneouses_id')
        ->where('data_collections.task_assign_id', $id)
        ->sum('d_c_spontaneouses.audio_duration');
        $total=$sumAudioDuration+$sumSpontTrimAudioDuration;

        $collected_time= number_format((float)$total, 2, '.', '');
        $firstItem = Arr::first($spontaneousTaskLanguages, function ($value, $key) {
            return $value;
        });

        return view('admin.task_assign.spontaneousList', compact('spontaneousTaskLanguages','sumAudioDuration','collected_time','firstItem'));
    }

    public function getTaskAssignByLanguageToday(){
        $TaskAssignByLanguageToday= TaskAssign::with(['directedTasks.topic'=>function ($query){
            $query->withCount('directeds');
        },  'spontaneousTasks.spontaneous','language',
            'district','upazila', 'union', 'collections.speaker', 'collections.dcSpontaneous.spontaneous', 'collections.dcDirected.dcSentence.directed.topics'])
            ->withCount( 'directedTasks', 'spontaneousTasks')
            // ->groupBy('language_id')
            ->latest()
            // ->limit(6)
            ->get();

            return view('admin.task_assign.task_assign_by_language_list',compact('TaskAssignByLanguageToday'));
    }
}
