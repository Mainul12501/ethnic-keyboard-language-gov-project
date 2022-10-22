<?php

namespace App\Http\Controllers;


use App\Models\DataCollection;
use App\Models\DCDirected;
use App\Models\DCDirectedSentence;
use App\Models\DCSpontaneous;
use App\Models\Directed;
use App\Models\DirectedTaskAssign;
use App\Models\SpontaneousTaskAssign;
use App\Models\Language;
use App\Models\Notification;
use App\Models\Speaker;
use App\Models\Spontaneous;
use App\Models\TaskAssign;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\LinguistTaskAssign;
use App\Models\ValidatorTaskAssign;
use Spatie\Activitylog\Models\Activity;
//use function PHPUnit\Framework\isEmpty;
// use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $allUsers =User::count();
        $languageCounts= Language::withCount(['directedLanguage','spontaneousLanguage'])->get();
        $totalSpeakers = Speaker::where('created_by', auth()->id())->count();
        $totalCollections= '';
        $notifications='';
        $totalLanguages= '';
        $totalDirectedTopics= '';
        $totalDirectedSentences= '';
        $totalSpontaneous= '';
        $totalCollectors='';
        $notificationCounts='';
        $todayDirecteds='';
        $todayDirctedCounts='';
        $todayDataCollections='';
        $todaycollections='';
        $todaySpontaneouses='';
        $todaySpontaneouCounts='';
        $taskAssignByLanguage='';
        $taskBycollections='';
        $totalLang='';
        $totalDirected='';
        $totalSpon='';
        $totalPendingSpon='';
        $totalDirPending='';
        $taskAssignByLinguists='';
        $taskAssignByValidators='';
        $todayDataCollects ='';
        $totalAudio ='';
        $result ='';
        $totalAudioApprove='';
        $resultApprove='';
        $login='';
        $todaystest='';


        $login=Activity::where('log_name','LIKE', "%{$login}%")
        ->whereDate('created_at', '=', Carbon::today()->toDateString())
        ->distinct()
        ->count('causer_id');
        // $directedsCollection = DCDirectedSentence::whereNotNull('audio')
        // ->with(['dcDirected'=>function($d){
        //     $d->with('collection.collector', 'collection.speaker','collection.language','collection.district', 'topic');
        // },'directed'])->get();
        // dd($directedsCollection);


        if (auth()->user()->user_type == 1){
               $todayDataCollects = DataCollection::whereDate('created_at', '=', Carbon::today()->toDateString())
                 ->with(['language','collector','taskAssign', /* 'dcSpontaneous.spontaneous',*/ 'dcDirected' =>function($q){
                    $q->with('topic' ,'dcSentence.directed')->get();
                } ])
                ->latest()->get();
                // $todayDataCollects= TaskAssign::with(['directedTasks.topic'=>function ($query){
                //     $query->withCount('directeds');

                // }, 'spontaneousTasks.spontaneous','language',
                //     'district','upazila', 'union', 'collections.speaker', 'collections.dcSpontaneous.spontaneous', 'collections.dcDirected.dcSentence.directed.topics'])
                //     ->where('user_id', auth()->id() )
                //     ->withCount( 'directedTasks', 'spontaneousTasks')
                //     ->latest()
                //     // ->limit(6)
                //     ->get();
                // return$todaycollections = DataCollection::whereDate('created_at', '=', Carbon::today()->toDateString())
                // ->count();
        }

        if (auth()->user()->user_type == 4){
            $totalCollectors ='';

            $directeds = DCDirectedSentence::where('status', 0)->where('created_by', auth()->id())->whereNotNull('approved_by')->count();
            $spontaneouses=DCSpontaneous::where('status', 0)->where('created_by', auth()->id())->whereNotNull('approved_by')->count();
            $totalPending =$directeds+$spontaneouses;

            $todayDataCollections = DataCollection::where('created_by', auth()->id())->whereDate('created_at', '=', Carbon::today()->toDateString())
                ->with(['language','collector', 'dcSpontaneous.spontaneous', 'dcDirected'=>function($q){
                    $q->with('topic','dcSentence.directed')->get();
                } ])->latest()->paginate(3);



            $totalCollections = DataCollection::where('created_by', auth()->id())->count();
            $todaycollections = DataCollection::where('collector_id', auth()->id())->whereDate('created_at', '=', Carbon::today()->toDateString())
                ->count();
            $totalLang= TaskAssign::where('user_id', auth()->id())->distinct('language_id')->count('language_id');
            $totalDirected=DirectedTaskAssign::where('user_id', auth()->id())->count('topic_id');

            $collectedDirNumber= DCDirected::join('data_collections', 'data_collections.id', '=', 'd_c_directeds.data_collection_id')
                ->select('topic_id','data_collections.id', 'data_collections.task_assign_id',DB::raw('COUNT(*) AS total_sentence'))
                ->where('data_collections.collector_id', auth()->id())
                ->groupBy('topic_id','data_collections.task_assign_id')
                ->get();

            $totalDirPending= $totalDirected- count($collectedDirNumber);
            $totalSpon=SpontaneousTaskAssign::where('user_id', auth()->id())->count('spontaneous_id');
            $collectedSponNumber=DataCollection::where('collector_id', auth()->id())
                ->where('type_id', 2)
                ->count();
            $totalPendingSpon=$totalSpon-$collectedSponNumber;

            // $taskAssignByLanguage= LinguistTaskAssign::where('user_id', auth()->id())
            // ->where('language_id')->get();
            // dd($taskAssignByLanguage);

            // return $tasks = TaskAssign::selectRaw( 'language_id', \DB::raw("COUNT(*) as count"))->where('user_id', Auth::id())
            //     ->with('language')
            //     ->orderBy('language_id')->get();
        //     $todayDataCollections=DB::table('d_c_directed_sentences')
        //     ->select(DB::raw('COUNT(audio) AS topic_wise_audio'))
        //     ->leftjoin('d_c_directeds', 'd_c_directed_sentences.d_c_directed_id', '=', 'd_c_directeds.id')
        //     ->leftjoin('data_collections', 'd_c_directeds.data_collection_id', '=', 'data_collections.id')
        //     // ->leftjoin('languages', 'data_collections.language_id', '=', 'languages.id')
        //     ->groupBy('data_collections.task_assign_id')
        //     ->get();
        //    dd($todayDataCollections->toArray());


          $taskAssignByLanguage= TaskAssign::with(['directedTasks.topic'=>function ($query){
                $query->withCount('directeds');

            }, 'spontaneousTasks.spontaneous','language.subLanguages',
                'district','upazila', 'union', 'collections.speaker', 'collections.dcSpontaneous.spontaneous', 'collections.dcDirected.dcSentence.directed.topics'])
                ->where('user_id', auth()->id() )
                ->withCount( 'directedTasks', 'spontaneousTasks')
                ->latest()
                // ->limit(6)
                // ->groupBy('directedTasks.topic')
                // ->sum('directeds.directeds_count')
                ->get();
            // dd($taskAssignByLanguage->toArray());
            // foreach($taskAssignByLanguage as $taskAssign)
            // {
            //     // return $taskAssign;
            //     return count($taskAssign->collections);
            // }


            $taskBycollections = TaskAssign::with(['speakers','collector', 'validators','directedTasks.topic'=>function($q){
                $q->withCount('directeds');
            },
                'spontaneousTasks.spontaneous','language',
                'district', /* 'collections.speaker', 'collections.dcSpontaneous.spontaneous', 'collections.dcDirected.dcSentence.directed.topics'*/])
                ->where('user_id', auth()->id() )
                ->withCount('directedTasks', 'spontaneousTasks')
                ->latest()
                // ->get();
                ->paginate(8);


            $notifications = Notification::where('user_id', auth()->id())->latest()->limit(5)->get();
            $notificationCounts =Notification::where('user_id', auth()->id())->count();


            $approvedDirecteds=DCDirectedSentence::where('status', 1)->where('created_by', auth()->id())->count();
            $approvedSpontaneouses=DCSpontaneous::where('status', 1)->where('created_by', auth()->id())->count();
            $totalApproved= $approvedDirecteds+$approvedSpontaneouses;

        }elseif (Auth::user()->hasRole(['Linguist','Validator'])){

            $todayDirecteds = Directed::with('topics')->where('created_by', auth()->id())
                ->whereDate('created_at', '=', Carbon::today()->toDateString())->paginate(5);
            $todayDirctedCounts = $todayDirecteds->count();

            $todaySpontaneouses =Spontaneous::where('created_by', auth()->id())
                ->whereDate('created_at', '=', Carbon::today()->toDateString())->paginate(5);
            $todaySpontaneouCounts =$todaySpontaneouses->count();

            // return$todaySpontaneouCounts= LinguistTaskAssign::where('user_id', auth()->id())
            // ->get();
            // $req=2;
            $languagebyLinguist= LinguistTaskAssign::where('user_id', auth()->id())
            ->pluck('language_id');
            // ->get();
            $taskAssignByLinguists = TaskAssign::with(['directedTasks.topic'=>function ($query){
                $query->withCount('directeds');

            }, 'spontaneousTasks.spontaneous','language',
                'district','upazila', 'union', 'collections.speaker', 'collections.dcSpontaneous.spontaneous', 'collections.dcDirected.dcSentence.directed.topics'])
                ->whereIn('language_id',$languagebyLinguist )
                ->withCount( 'directedTasks', 'spontaneousTasks')
                ->latest()
                // ->limit(6)
                ->get();

            // ->get();
            $languagebyValidator= ValidatorTaskAssign::where('user_id', auth()->id())
            ->pluck('language_id');
            $taskAssignByValidators = TaskAssign::with(['directedTasks.topic'=>function ($query){
                $query->withCount('directeds');

            }, 'spontaneousTasks.spontaneous','language',
                'district','upazila', 'union', 'collections.speaker', 'collections.dcSpontaneous.spontaneous', 'collections.dcDirected.dcSentence.directed.topics'])
                ->whereIn('language_id',$languagebyValidator )
                ->withCount( 'directedTasks', 'spontaneousTasks')
                ->latest()
                // ->limit(6)
                ->get();
                // dd($taskAssignByLinguists->toArray());

            $totalLanguages=Language::count();
            $totalDirectedTopics=Topic::count();
            $totalDirectedSentences= Directed::count();
            $totalSpontaneous = Spontaneous::count();

           $taskAssignByLanguage= TaskAssign::with(['directedTasks.topic'=>function ($query){
                $query->withCount('directeds');
            },  'spontaneousTasks.spontaneous','language',
                'district','upazila', 'union', 'collections.speaker', 'collections.dcSpontaneous.spontaneous', 'collections.dcDirected.dcSentence.directed.topics'])
                ->withCount( 'directedTasks', 'spontaneousTasks')
                // ->groupBy('language_id')
                ->latest()
                // ->limit(6)
                ->get();
            // dd($taskAssignByLanguage->toArray());


            $taskBycollections = TaskAssign::with(['speakers','collector', 'validators', 'directedTasks.topic'=>function($q){
                $q->with('directeds');
                $q->withCount('directeds');
            },
                'spontaneousTasks.spontaneous','language',
                'district', /*'collections.speaker', 'collections.dcSpontaneous.spontaneous', 'collections.dcDirected.dcSentence.directed.topics'*/])
                ->withCount('directedTasks', 'spontaneousTasks')
                ->latest()
                ->paginate(8);
        //    dd($taskBycollections->toArray());

            $notifications = Notification::where('user_id', auth()->id())->latest()->limit(5)->get();
            $notificationCounts =Notification::where('user_id', auth()->id())->count();


            $directeds = DCDirectedSentence::where('status', 0)->whereNotNull('approved_by')->count();
            $spontaneouses=DCSpontaneous::where('status', 0)->whereNotNull('approved_by')->count();
            $totalPending =$directeds+$spontaneouses;

            $approvedDirecteds=DCDirectedSentence::where('status', 1)->count();
            $approvedSpontaneouses=DCSpontaneous::where('status', 1)->count();
            $totalApproved= $approvedDirecteds+$approvedSpontaneouses;

        }else{

            $totalCollectors = User::where('user_type', 4)->count();
            $directeds = DCDirectedSentence::where('status', 0)->whereNotNull('approved_by')->count();
            $spontaneouses=DCSpontaneous::where('status', 0)->whereNotNull('approved_by')->count();
            $totalPending =$directeds+$spontaneouses;

            $totalCollections = DataCollection::count();

           $todayDataCollections = DataCollection::whereDate('created_at', '=', Carbon::today()->toDateString())
                ->with(['language','collector', 'dcSpontaneous.spontaneous', 'dcDirected'=>function($q){
                    $q->with('topic','dcSentence.directed')->get();
                } ])->latest()
                // ->groupBy('language_id')
                ->paginate(3);
                // ->get();
                $todayData = DataCollection::whereDate('created_at', '=', Carbon::today()->toDateString())
                ->with(['language','collector', 'dcSpontaneous.spontaneous', 'dcDirected'=>function($q){
                    $q->with('topic','dcSentence.directed')->get();
                } ])->latest()
                // ->groupBy('language_id')
                // ->paginate(3);
                ->get();
                $todaystest=$todayData->groupBy('language_id','district_id');
                $taskBycollections = TaskAssign::with(['speakers','collector', 'validators','directedTasks.topic'=>function($q){
                    $q->withCount('directeds');
                },
                    'spontaneousTasks.spontaneous','language',
                    'district','collections.speaker', 'collections.dcSpontaneous.spontaneous', 'collections.dcDirected.dcSentence.directed.topics'])
                    // ->where('user_id', auth()->id() )
                    ->withCount('directedTasks', 'spontaneousTasks')
                    ->whereDate('created_at', '=', Carbon::today()->toDateString())
                    ->latest()->get();
                   $t=$taskBycollections->groupBy('language_id','district_id');
                    // ->paginate(8);
                // foreach($todaystest as $key=> $test)
                // {
                //     // foreach($test as $te)
                //     // {
                //     //     // dd($t->language->name);
                //     //     $te;
                //     // }

                //     // dd($todaystest[$key]);
                // }
            // return$todayDataCollections = DataCollection::
            // with(['language','collector', 'dcSpontaneous.spontaneous', 'dcDirected'=>function($q){
            //     $q->with('topic','dcSentence.directed')->get();
            // } ])->latest()
            // ->select('data_collections.*', DB::raw('group_concat(task_assign_id) as names','group_concat(collector.name) as Collector names'))

            //     ->groupBy('language_id')
            //     -> whereDate('created_at', '=', Carbon::today()->toDateString())
            //     ->get();
            //     // ->paginate(3);

            $todaycollections = DataCollection::whereDate('created_at', '=', Carbon::today()->toDateString())
                ->count();


            // return$taskAssignByLanguage = Language::withCount(['taskAssign'])->get();
            $taskAssignByLanguage = TaskAssign::whereDate('created_at', '=', Carbon::today()->toDateString())->groupBy(['language_id'])->get();
            // $taskAssignByLanguage = TaskAssign::whereDate('created_at', '=', Carbon::today()->toDateString())->get();
            $approvedDirecteds=DCDirectedSentence::where('status', 1)->count();
            $approvedSpontaneouses=DCSpontaneous::where('status', 1)->count();
            $totalApproved= $approvedDirecteds+$approvedSpontaneouses;
             /* $todayDataCollections =DCDirectedSentence::with(['dcDirected.collection'=>function($q){
                $q->groupBy('language_id');
             }])
            ->get(); */
            // $test=DataCollection::sum('la')
            // dd($todayDataCollections->toArray());

            //language wise total time

            $totalDirectedAudio=DB::table('d_c_directed_sentences')
            ->select(DB::raw('SUM(audio_duration) AS sum_of_length'), 'languages.name')
            ->leftjoin('d_c_directeds', 'd_c_directed_sentences.d_c_directed_id', '=', 'd_c_directeds.id')
            ->leftjoin('data_collections', 'd_c_directeds.data_collection_id', '=', 'data_collections.id')
            ->leftjoin('languages', 'data_collections.language_id', '=', 'languages.id')
            // ->where('d_c_directed_sentences.validation_status', '=', 1)
            ->groupBy('data_collections.language_id')
            ->get()->toArray();


            $totalSpontAudio=DB::table('d_c_spontaneouses')
            ->select(DB::raw('SUM(audio_duration) AS sum_of_length'), 'languages.name')
            // ->leftjoin('d_c_directeds', 'd_c_directed_sentences.d_c_directed_id', '=', 'd_c_directeds.id')
            ->leftjoin('data_collections', 'd_c_spontaneouses.data_collection_id', '=', 'data_collections.id')
            ->leftjoin('languages', 'data_collections.language_id', '=', 'languages.id')
            ->groupBy('data_collections.language_id')
            ->get()->toArray();
            // return gettype($totalDirectedAudio);
        //    $totalAudio=array_merge($totalDirectedAudio,$totalSpontAudio);
            $output = array_merge_recursive($totalDirectedAudio, $totalSpontAudio);
    //    return $output;
    // $sum=array();
    //    foreach ($output as $item) {
    //     // return $item;
    //     if (!isset($sum[$item->name])) $sum[$item->name] = 0;
    //     $sum[$item->name] += $item->sum_of_length;
    // }
    // return $sum;
        // return gettype($output);
         /* return */ $totalAudio = array_reduce($output, function($result, $item) {
            if (!isset($result[$item->name])) $result[$item->name] = 0;
            $result[$item->name] += $item->sum_of_length;
            return $result;
        }, array());
        $result= [];
        foreach($totalAudio as $key=>$audio)
        {
            $result[]=[$key,$audio];

        }
        // return $result;
        //total validate time
        $totalDirecteValidatedAudio=DB::table('d_c_directed_sentences')
            ->select(DB::raw('SUM(audio_duration) AS sum_of_length'), 'languages.name')
            ->leftjoin('d_c_directeds', 'd_c_directed_sentences.d_c_directed_id', '=', 'd_c_directeds.id')
            ->leftjoin('data_collections', 'd_c_directeds.data_collection_id', '=', 'data_collections.id')
            ->leftjoin('languages', 'data_collections.language_id', '=', 'languages.id')
            ->where('d_c_directed_sentences.validation_status', '=', 1)
            ->groupBy('data_collections.language_id')
            ->get()->toArray();


            $totalSpontValidateAudio=DB::table('d_c_spontaneouses')
            ->select(DB::raw('SUM(audio_duration) AS sum_of_length'), 'languages.name')
            // ->leftjoin('d_c_directeds', 'd_c_directed_sentences.d_c_directed_id', '=', 'd_c_directeds.id')
            ->leftjoin('data_collections', 'd_c_spontaneouses.data_collection_id', '=', 'data_collections.id')
            ->leftjoin('languages', 'data_collections.language_id', '=', 'languages.id')
            ->where('d_c_spontaneouses.validation_status', '=', 1)
            ->groupBy('data_collections.language_id')
            ->get()->toArray();

            $outputValidated = array_merge_recursive($totalDirecteValidatedAudio, $totalSpontValidateAudio);

            /* return */ $totalAudio = array_reduce($output, function($result, $item) {
                if (!isset($result[$item->name])) $result[$item->name] = 0;
                $result[$item->name] += $item->sum_of_length;
                return $result;
            }, array());
            $result= [];
            foreach($totalAudio as $key=>$audio)
            {
                $result[]=[$key,$audio];

            }
            // end total validate time

        //approve graph
         /* return */$totalDirectedApprove=DB::table('d_c_directed_sentences')
         ->select(DB::raw('SUM(audio_duration) AS sum_of_length'), 'languages.name')
         ->leftjoin('d_c_directeds', 'd_c_directed_sentences.d_c_directed_id', '=', 'd_c_directeds.id')
         ->leftjoin('data_collections', 'd_c_directeds.data_collection_id', '=', 'data_collections.id')
         ->leftjoin('languages', 'data_collections.language_id', '=', 'languages.id')
         ->where('d_c_directed_sentences.status',1)
         ->groupBy('data_collections.language_id')
         ->get()->toArray();
        //  return gettype($totalDirectedAudio);
         $totalSpontApprove=DB::table('d_c_spontaneouses')
         ->select(DB::raw('SUM(audio_duration) AS sum_of_length'), 'languages.name')
         // ->leftjoin('d_c_directeds', 'd_c_directed_sentences.d_c_directed_id', '=', 'd_c_directeds.id')
         ->leftjoin('data_collections', 'd_c_spontaneouses.data_collection_id', '=', 'data_collections.id')
         ->leftjoin('languages', 'data_collections.language_id', '=', 'languages.id')
         ->where('d_c_spontaneouses.status',1)
         ->groupBy('data_collections.language_id')
         ->get()->toArray();

         $outputApprove = array_merge_recursive($totalDirectedApprove, $totalSpontApprove);
            /* return */ $totalAudioApprove = array_reduce($outputApprove, function($result, $item) {
                if (!isset($result[$item->name])) $result[$item->name] = 0;
                $result[$item->name] += $item->sum_of_length;
                return $result;
            }, array());
            $resultApprove= [];
            foreach($totalAudioApprove as $key=>$audio)
            {
                $resultApprove[]=[$key,$audio];

            }

        }

        // $pieChart = DataCollection::select(\DB::raw('audio_duration as audio_duration '), \DB::raw("SUM(*) as sum"))
        //     ->whereYear('created_at', date('Y'))
        //     ->groupBy('month_name')
        //     ->orderBy('sum')
        //     ->get();
            $barDirecteds =Language::with(['dataCollection'=>function($query){
                $query->with(['dcDirected.dcSentence'=>function($q){
                    $q->whereNotNull('approved_by')->get();
                }])->where('type_id', 1)->get();
            }])
                ->get();

        $barSpontaneous =Language::with(['dataCollection'=>function($query){
            $query->where('type_id', 2)->get();
        }])
            ->get();

        $languages = Language::pluck('name', 'id');

        return view('dashboard',
            compact('allUsers', 'languageCounts', 'totalApproved', 'totalPending', 'totalCollectors',
                'todayDataCollections', 'todaycollections', 'totalCollections', 'barDirecteds','barSpontaneous',
                'languages','totalSpeakers', 'taskAssignByLanguage', 'notifications','notificationCounts', 'totalLanguages',
                'totalDirectedTopics','totalDirectedSentences', 'totalSpontaneous', 'todayDirecteds', 'todayDirctedCounts',
                'todaySpontaneouses', 'todaySpontaneouCounts', 'taskBycollections',
                'todaySpontaneouses', 'todaySpontaneouCounts',
                'totalLang','totalDirected','totalSpon','totalPendingSpon','totalDirPending','taskAssignByLinguists',
                 'taskAssignByValidators','todayDataCollects','totalAudio','result','totalAudioApprove','resultApprove',
                'login','todaystest'));

    }

    /*public function languageDemo(){
        return view('languageDemo');
    }*/
}
