<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AudioTrim;
use App\Models\DataCollection;
use App\Models\DCDirected;
use App\Models\DCDirectedSentence;
use App\Models\DCSpontaneous;
use App\Models\Directed;
use App\Models\DirectedLanguage;
use App\Models\DirectedTaskAssign;
use App\Models\District;
use App\Models\Group;
use App\Models\GroupCollectors;
use App\Models\Speaker;
use App\Models\Spontaneous;
use App\Models\SpontaneousLanguage;
use App\Models\SpontaneousTaskAssign;
use App\Models\TaskAssign;
use App\Models\Union;
use App\Models\Upazila;
use App\Models\Village;
use App\Models\Language;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lame\Lame;
use Lame\Settings\Encoding\Preset;
use Lame\Settings\Settings;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Null_;
use File;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;


class DataCollectionController extends Controller
{


    public function showDataCollectionWithTrim($type, $id, Request $request){
        if ($type == 'directed')
        {
              $audio = DCDirectedSentence::with(['dcDirected'=>function($q){
                $q->with(['collection.language','collection.district','collection.collector', 'collection.speaker', 'collection.taskAssign'=>function($e){$e->with('group');}, 'topic']);}, 'directed'])
                ->findOrFail($id);
        } elseif ($type == 'spontaneous')
        {
            $audio = DCSpontaneous::with(['collection'=>function($e){$e->with(['collector', 'speaker',
                'taskAssign'=>function($q){$q->with('group');}]);}, 'spontaneous'])
                ->findOrFail($id);

        }

        $trims = [];
        $directedAudios = AudioTrim::where('d_c_directed_sentences_id',  $request->id)
            ->latest()->get();
        if ($directedAudios->isNotEmpty())
        {
            foreach ($directedAudios as $directedAudio)
            {
                array_push($trims, $directedAudio);
            }
        }
        $spontinoursAudios = AudioTrim::where('d_c_spontaneouses_id', $request->id)->latest()->get();
        if ($spontinoursAudios->isNotEmpty())
        {
            foreach ($spontinoursAudios as $spontinoursAudio)
            {
                array_push($trims, $spontinoursAudio);
            }
        }

        $trims = array_filter($trims);

        return view('admin.data_collection.show', compact('type', 'audio', 'trims'));
    }


    public function pendingCollectionList(){
        $directeds = DCDirectedSentence::whereNotNull('approved_by')
            ->where('status', '0')
            ->with(['dcDirected'=>function($d){
                $d->with('collection.collector', 'collection.speaker','collection.language','collection.district', 'topic');
            },'directed'])->latest()->get();
        $spontaneouses=DCSpontaneous::whereNotNull('approved_by')
            ->where('status', '0')
            ->with('collection.collector', 'collection.speaker','collection.language','collection.district','spontaneous')
            ->latest()->get();
        $dataCollections = $directeds->mergeRecursive($spontaneouses)->all();

        return view('admin.data_collection.pendingList',compact('dataCollections'));
    }




    public function audioList(){
        $directeds = DCDirectedSentence::where('approved_by', null)->with(['dcDirected'=>function($d){
            $d->with('collection.language','collection.district', 'topic');
        },'directed'])->latest()->get();
        $spontaneouses=DCSpontaneous::where('approved_by', null)->with('collection.language','collection.district','spontaneous')->latest()->get();
        $dataCollections = $spontaneouses->mergeRecursive($directeds)->all();

        return response()->json($dataCollections);
    }

    public function userPending(){
        $directeds = DCDirectedSentence::whereNotNull('approved_by')
        ->where('created_by', auth()->id())
        ->where('status', '0')
        ->with(['dcDirected'=>function($d){
            $d->with('collection.collector', 'collection.speaker','collection.language','collection.district', 'topic');
        },'directed'])->latest()->get();
    $spontaneouses=DCSpontaneous::whereNotNull('approved_by')
        ->where('created_by', auth()->id())
        ->where('status', '0')
        ->with('collection.collector', 'collection.speaker','collection.language','collection.district','spontaneous')
        ->latest()->get();
    $dataCollections = $directeds->mergeRecursive($spontaneouses)->all();

    return view('admin.data_collection.userPendingList',compact('dataCollections'));

    }
    public function userApproval(){
        $directeds = DCDirectedSentence::whereNotNull('approved_by')
        // ->where('created_by', auth()->id())
        ->where('status', '1')
        ->with(['dcDirected'=>function($d){
            $d->with('collection.collector', 'collection.speaker','collection.language','collection.district', 'topic');
        },'directed'])->latest()->get();
    $spontaneouses=DCSpontaneous::whereNotNull('approved_by')
        // ->where('created_by', auth()->id())
        ->where('status', '1')
        ->with('collection.collector', 'collection.speaker','collection.language','collection.district','spontaneous')
        ->latest()->get();
    /* return */$dataCollections = $directeds->mergeRecursive($spontaneouses)->all();

    return view('admin.data_collection.userApprovalList',compact('dataCollections'));

    }

    public function index(Request $request){
        // return$directeds = DCDirectedSentence::whereNotNull('approved_by')
        // ->where('created_by', auth()->id())
        // ->where('status', '0')
        // ->with(['dcDirected'=>function($d){
        //     $d->with('collection.collector', 'collection.speaker','collection.language','collection.district', 'topic');
        // },'directed'])->latest()->get();

        // return$spontaneouses=DCSpontaneous::whereNotNull('approved_by')
        //     ->where('status', '0')
        //     ->where('created_by', auth()->id())
        //     ->with('collection.collector', 'collection.speaker','collection.language','collection.district','spontaneous')
        //     ->latest()->get();

        if (Auth::user()->user_type == 4){

            $dataCollections= DataCollection::where('created_by', auth()->id())
                ->with('language', 'district', 'collector', 'speaker')
                ->groupBy(['language_id', 'collector_id', 'speaker_id', 'district_id'])
                ->latest()
                ->get();
            $languages = DataCollection::where('created_by', auth()->id())
                ->with('language')->groupBy('language_id')->get();
            $districts = DataCollection::where('created_by', auth()->id())
                ->with('district')->groupBy('district_id')->get();
            $collectors = DataCollection::where('created_by', auth()->id())
                ->with('collector')->groupBy('collector_id')->get();
            $speakers = DataCollection::where('created_by', auth()->id())
                ->with('speaker')->groupBy('speaker_id')->get();

            if($request->language_id != '' || $request->district_id != '' ||$request->speaker_id != ''){

                $query = DataCollection::query();

                if (isset($request->language_id)) {
                    $query->whereIn('language_id', [$request->language_id])
                        ->whereIn('collector_id', [auth()->id()]);
                }
                if (isset($request->district_id)) {
                    $query->whereIn('district_id', [$request->district_id])
                        ->whereIn('collector_id', [auth()->id()]);
                }
                if (isset($request->speaker_id)) {
                    $query->whereIn('speaker_id', [$request->speaker_id]);
                }
                $dataCollections = $query;
                $dataCollections=$dataCollections->with('language', 'district', 'collector', 'speaker')
                    ->groupBy(['language_id', 'collector_id', 'speaker_id', 'district_id'])
                    ->latest()
                    ->get();
            }

        }else{

            $dataCollections= DataCollection::with('language', 'district', 'collector', 'speaker')
                ->groupBy(['language_id', 'collector_id', 'speaker_id', 'district_id'])
                ->latest()
                ->get();
            $languages = DataCollection::with('language')->groupBy('language_id')->get();
            $districts = DataCollection::with('district')->groupBy('district_id')->get();
            $collectors = DataCollection::with('collector')->groupBy('collector_id')->get();
            $speakers = DataCollection::with('speaker')->groupBy('speaker_id')->get();

            if($request->language_id != '' || $request->district_id != '' ||$request->collector_id != '' ||$request->speaker_id != ''){

                $query = DataCollection::query();

                if (isset($request->language_id)) {
                    $query->whereIn('language_id', [$request->language_id]);
                }
                if (isset($request->district_id)) {
                    $query->whereIn('district_id', [$request->district_id]);
                }
                if (isset($request->collector_id)) {
                    $query->whereIn('collector_id', [$request->collector_id]);
                }
                if (isset($request->speaker_id)) {
                    $query->whereIn('speaker_id', [$request->speaker_id]);
                }
                $dataCollections = $query;
                $dataCollections=$dataCollections->with('language', 'district', 'collector', 'speaker')
                    ->groupBy(['language_id', 'collector_id', 'speaker_id', 'district_id'])
                    ->latest()
                    ->get();
            }
        }
        $selected_id = [];
        $selected_id['language_id'] = $request->language_id;
        $selected_id['district_id'] = $request->district_id;
        $selected_id['collector_id'] = $request->collector_id;
        $selected_id['speaker_id'] = $request->speaker_id;



        return view('admin.data_collection.index',
            compact('dataCollections', 'languages', 'districts', 'collectors', 'speakers', 'selected_id'));
    }


    public function dataCollectionCorrectionList(){
        if ((Auth::user()->user_type == 4) ){

            $directeds = DCDirectedSentence::where('created_by', auth()->id())->where('status', 2)->with(['dcDirected'=>function($d){
                $d->with('collection.collector', 'collection.speaker','collection.language','collection.district', 'topic');
            },'directed'])->latest()->get();
            $spontaneouses=DCSpontaneous::where('created_by', auth()->id())->where('status', 2)
                ->with('collection.collector', 'collection.speaker','collection.language','collection.district','spontaneous')
                ->latest()
                ->get();
           /*  return */$dataCollections = $directeds->mergeRecursive($spontaneouses)->all();
        }


        return view('admin.data_collection.correctionList',compact('dataCollections'));
    }
    public function dataCollectionCorrectionForAdminList(){

           $directeds = DCDirectedSentence::where('status', 2)->with(['dcDirected'=>function($d){
                $d->with('collection.collector', 'collection.speaker','collection.language','collection.district', 'topic');
            },'directed'])->latest()->get();
            // $spontaneouses=DCSpontaneous::where('status', 2)
            //     ->with('collection.collector', 'collection.speaker','collection.language','collection.district','spontaneous')
            //     ->latest()
            //     ->get();
            $spontaneouses=AudioTrim::where('status', 2)->with(['dcSpontaneous'=>function($d){
                $d->with('collection.collector', 'collection.speaker','collection.language','collection.district','spontaneous');
            },'dcSpontaneous']) ->latest()
            ->get();
              $dataCollections = $directeds->mergeRecursive($spontaneouses)->all();


        return view('admin.user_wise_data_collection.CorrectionList',compact('dataCollections'));
    }



    public function create(Request $request)
    {
        $speakers = Speaker::where('created_by', auth()->id())->get();
        $districts = District::pluck('name', 'id');
        $languages=[];
        $tasks = TaskAssign::where('user_id', Auth::id())
            ->with('language','district')->get();

        if ($tasks->isNotEmpty()){
            $languages=$tasks;
        }

        return view('admin.data_collection.create', [
            'languages' => $languages,
            'speakers'  => $speakers,
            'districts'  => $districts,
        ]);
    }




    public function getTypeContent (Request $request)
    {
        if ($request->type_value == 'directeds')
        {

            $directedLanguages =DirectedTaskAssign::where('user_id', auth()->id())
                ->with('taskAssign.language','taskAssign.district', 'topic')
                ->whereHas('taskAssign', function ($q) use ($request){
                    return $q->where('language_id',$request->language_id)
                        ->where('district_id', $request->district_id);
                })->get();

            if (!isset($directedLanguages))
            {
                $directedLanguages = 'blank';
            }
            $result = [
                'typeContent' => $directedLanguages,
                'type'      => 'directeds',
                'districtID'      => $request->district_id
            ];
        }elseif ($request->type_value == 'spontaneouses')
        {
            $spontaneouses = SpontaneousTaskAssign::where('user_id', auth()->id())
                ->with('taskAssign.language','spontaneous')
                ->whereHas('taskAssign', function ($q) use ($request){
                    return $q->where('language_id', $request->language_id)
                        ->where('district_id', $request->district_id);
                })->get();

            if (!isset($spontaneouses))
            {
                $spontaneouses = 'blank';
            }
            $result = [
                'typeContent' => $spontaneouses,
                'type'      => 'spontaneouses',
                'districtID'      => $request->district_id
            ];
        }
        return json_encode($result);
    }
    public function checkSponInDc (Request $request)
    {
        $status = DCSpontaneous::where('spontaneous_id',$request->id)->first();
        if (!empty($status))
        {
            return json_encode(1);
        } else {
            return json_encode(0);
        }
    }

    public function getTypeSubContent (Request $request)
    {

        if ($request->type == 'directeds')
        {
            $contents = Directed::where('topic_id', $request->topic_id)->with('dcSentence')->get();

            $result = [
                'contents' => $contents,
                'type'  => 'directeds',
                'topicId'  => $request->topic_id,
                'taskAssignId'  => $request->task_assign_id,
                'districtID'  => $request->district_id,
            ];
        } elseif ($request->type == 'spontaneouses')
        {

            $contents = Spontaneous::where('id', $request->id)->get();
            $result = [
                'contents' => $contents,
                'type'  => 'spontaneouses',

            ];
        }
        return json_encode($result);
    }
    public function checkSpoAudioStatus (Request $request)
    {

        if ($request->type == 'directeds')
        {
            $status = DCDirectedSentence::where('directed_id', $request->dir_id)
                ->with('dcDirected.collection')
                ->whereHas('dcDirected', function ($q) use ($request){
                    $q->where('topic_id', $request->topic_id);
                })
                ->whereHas('dcDirected.collection', function ($s) use ($request){
                    return $s->where('task_assign_id', $request->task_assign_id)
                        ->where('language_id', $request->language_id)
                        ->where('district_id', $request->district_id);
                })
                ->first();


        } elseif ($request->type == 'spontaneouses')
        {
            $status = DCSpontaneous::where('spontaneous_id', $request->dir_id)->with('collection')
                ->whereHas('collection', function ($q) use ($request){
                    return $q->where('task_assign_id', $request->task_assign_id)
                        ->where('language_id', $request->language_id)
                        ->where('district_id', $request->district_id);
                })->first();
        }
        if (!empty($status))
        {
            $result = [
                'status' => 1,
                'audio' => $status
            ];
        } else {
            $result = [
                'status' => 0,
                'audio' => 'blank',
            ];
        }

        return json_encode($result);
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


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'language_id' => 'required',
                'type_id'  => 'required',
                'audio' => 'required',
                'speaker_id' => 'required',
            ]);

            // if($validator->fails()){
            //     return redirect()->back()->with($validator ,'error', __('messages.কিছু ভুল হয়েছে। আবার চেষ্টা করুন।'));

            // }
            if ($request->audio_file == !null) {

                $decoded_file = $request->audio_file;  //Decoded audio file
                $audio_parts  = explode(";base64,", $decoded_file);
                $audio_type   = explode("audio/wav", $audio_parts[0]);
                $audio_base64 = base64_decode($audio_parts[1]);
                $audio_directory = './uploads/data-collections/';
//            $file_name = 'record_'.time().'.mp3';
                $file_name_no_ext = 'record_'.time();
                $file_name = $file_name_no_ext.'.wav';
                $record = file_put_contents($audio_directory.$file_name, $audio_base64);
                $wav_audio_url = $audio_directory.$file_name;
                $audio_re_file = $request->audio_blob;
                $audio_file = str_replace('data:audio/wav;base64,', '', $audio_re_file);
                // $newfile_name = 'record_'.time().'.mp3';
                // $audio_part = $request ->


                /*Audio converter
                 \FFMpeg::fromDisk('custom')
                     ->open($file_name)
                     ->export()
                     ->toDisk('custom')
                     ->inFormat((new \FFMpeg\Format\Audio\Mp3)->setAudioKiloBitrate(320)->setAudioChannels(2)->setAudioCodec('libmp3lame'))
                     ->save($file_name_no_ext.'.mp3');*/
                $audio_url = $audio_directory.$file_name_no_ext.'.mp3';
                /* if (file_exists($wav_audio_url))
                 {
                     unlink($wav_audio_url);
                 }*/

                if ($request->speaker_id == null)
                {
                    $speaker = $this->speaker($request);
                }

                $dataCollection = $this->dataCollection($request, ($request->speaker_id == null) ? $speaker->id : $request->speaker_id);

                if ($request->type_id == 'directeds')
                {
                    $dcDirect = $this->dcDirect($dataCollection->id,  $request->target_id);
                    $dcDirectSentence = $this->dcDirectSentence($request, $dcDirect, $audio_url, $request->target_id, $audio_file);
                } else {
                    $dcSpont = $this->dcSpont($request, $dataCollection->id, $audio_url, $request->target_id, $audio_file);
                }

            }else{
                if ($request->speaker_id == null)
                {
                    $speaker = $this->speaker($request);
                }
                $dataCollection = $this->dataCollection($request, ($request->speaker_id == null) ? $speaker->id : $request->speaker_id);
                foreach ($request->file('audio') as $key => $item)
                {
                    $audio_src  = file_get_contents( $item);
                    $audio_file = base64_encode( $audio_src);
                    if($request->hasFile('audio')){
                        $audioName  =   time().rand(10,1000).'.'.$item->getClientOriginalExtension();
                        $directory  =   './uploads/data-collections/';
                        $audioUrl   =   $directory.$audioName;

                        $file = $item->move($directory, $audioName);
                    }

                    if ($request->type_id == 'directeds')
                    {
                        $dcDirect = $this->dcDirect($dataCollection->id, $key);
                        $dcDirectSentence = $this->dcDirectSentence($request, $dcDirect, $audioUrl, $key,$audio_file);
                    } else {
                        $dcSpont = $this->dcSpont($request, $dataCollection->id, $audioUrl, $key , $audio_file);
                    }
                }
            }
            DB::commit();
            return redirect()->back()->with('success', __('messages.আপনার ডাটাটি সফলভাবে সংগ্রহ হয়েছে।'));

        }catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', __('messages.কিছু ভুল হয়েছে। আবার চেষ্টা করুন।'));
        }
    }

    protected function dcSpont ($request, $dataCollection, $audioUrl, $spo_id, $audio_file)
    {
        $dcSpont = new DCSpontaneous();
        $ffprobe    = \FFMpeg\FFProbe::create();
        $dcSpont->data_collection_id = $dataCollection;
        if ($request->hasFile('audio')) {

            $dcSpont->audio = $request->hasFile('audio') ? $audioUrl : '';
            $dcSpont->audio_blob = $audio_file;
            $duration=$ffprobe->format($audioUrl)->get('duration');
            $length = $duration/60;
            $dcSpont->audio_duration  = $length;

        }elseif ($request->audio_file == !null) {

            $dcSpont->audio      = $audioUrl;
            $dcSpont->audio_blob = $audio_file;
            $duration=$ffprobe->format($audioUrl)->get('duration');
            $length = $duration/60;
            $dcSpont->audio_duration  = $length;
        }
        $dcSpont->spontaneous_id = $spo_id;
        $dcSpont->bangla = $request->bangla;
        $dcSpont->english  = $request->english;
        $dcSpont->transcription  = $request->transcription;
        $dcSpont->approved_date = Carbon::today()->toDateTimeString();
        $dcSpont->created_by = Auth::id();
        $dcSpont->updated_by = Auth::id();
        $dcSpont->save();
        return $dcSpont;
    }

    protected function dcDirectSentence ($request , /* $record_length, */  $dcDirect, $audioUrl, $directed_id, $audio_file)
    {
        // return $request->all();

        $dcDirectSentence = new DCDirectedSentence();
        $ffprobe    = \FFMpeg\FFProbe::create();
        if ($request->hasFile('audio')) {

            $dcDirectSentence->audio = $request->hasFile('audio') ? $audioUrl : '';
            $dcDirectSentence->audio_blob = $audio_file;
            $duration=$ffprobe->format($audioUrl)->get('duration');
            $length=$duration/60;
            $dcDirectSentence->audio_duration  = $length;


        }elseif ($request->audio_file == !null) {

            $dcDirectSentence->audio      = $audioUrl;
            $dcDirectSentence->audio_blob = $audio_file;
            $duration=$ffprobe->format($audioUrl)->get('duration');
            $length=$duration/60;
            $dcDirectSentence->audio_duration  = $length;

        }
        $dcDirectSentence->d_c_directed_id  = $dcDirect->id;
        // $dcDirectSentence->english  = $request->english;
        $dcDirectSentence->transcription  = $request->transcription;
        $dcDirectSentence->directed_id   = $directed_id;
        $dcDirectSentence->topic_status   = 2;
        $dcDirectSentence->approved_date   = Carbon::today()->toDateTimeString();
        $dcDirectSentence->created_by   = Auth::id();
        $dcDirectSentence->updated_by   = 0;
        $dcDirectSentence->updated_at   = NULL;
        $dcDirectSentence->save();
        return $dcDirectSentence;
    }

    protected function dataCollection ($request, $speaker)
    {
        // return $request->all();
        $dataCollection = new DataCollection();
        $dataCollection->type_id = $request->type_id == 'directeds' ? 1 : 2;
        $dataCollection->language_id = $request->language_id;
        $dataCollection->district_id = $request->district_id;
        $dataCollection->task_assign_id = $request->task_assign_id;
        $dataCollection->collector_id  = Auth::id();
        $dataCollection->speaker_id  = $speaker;
        $dataCollection->created_by  = Auth::id();
        $dataCollection->updated_by  = Auth::id();
        $dataCollection->save();
        return  $dataCollection;
    }

    protected function speaker (Request $request)
    {

        $request->validate([
            'name'      => 'required|string',
            'gender'    => 'required',
            'image'    => 'required|image',
            'phone' => 'required|regex:/(01)[0-9]{9}/|min:11|max:11|unique:speakers',
            'age'    => 'required|min:1|max:3',
            'occupation'    => 'required',
            'district'    => 'required',
            'upazila_id'    => 'required',
            'union_id'    => 'required',
        ]);

        $speaker = new Speaker();
        $speaker->name= $request->name;
        $speaker->age      = $request->age;
        $speaker->occupation      = $request->occupation;
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
        $speaker->image      = $this->imageUpload($request);
        $speaker->save();
        return $speaker;
    }

    protected function dcDirect ($dataCollectionID, $topicID)
    {
        $dcDirect = new DCDirected();
        $dcDirect->data_collection_id = $dataCollectionID;
        $dcDirect->topic_id = $topicID;
        $dcDirect->created_by = Auth::id();
        $dcDirect->updated_by = 0;
        $dcDirect->save();
        return $dcDirect;
    }

    public function show($id)
    {
        $spontaneous = DCSpontaneous::with(['collection.language', 'collection.district','collection'=>function($e){$e->with(['collector', 'speaker',
            'taskAssign'=>function($q){$q->with('group');}]);}, 'spontaneous'])
            ->where('id', $id)->first();
//        return $spontaneous;
        return view('admin.data_collection.show', compact('spontaneous'));
    }

    public function showDirected($id){
        $directed = DCDirectedSentence::with(['dcDirected'=>function($q){
            $q->with(['collection.language','collection.district','collection.collector', 'collection.speaker', 'collection.taskAssign'=>function($e){$e->with('group');}, 'topic']);}, 'directed'])
            ->where('id', $id)->first();
    //    return $directed;
        return view('admin.data_collection.showDirected', compact('directed'));
    }

    public function edit($id)
    {
        $spontaneousAudio = DCSpontaneous::with(['collection'=>function($e){$e->with(['collector', 'speaker',
            'taskAssign'=>function($q){$q->with('group');}]);}, 'spontaneous'])
            ->where('id', $id)->first();
//        return $spontaneousAudio;
        return view('admin.data_collection.edit', compact('spontaneousAudio'));
    }


    public function editDirected($id){
        $directedAudio = DCDirectedSentence::with(['dcDirected'=>function($q){
            $q->with(['collection.district','collection.language','collection.collector', 'collection.speaker', 'collection.taskAssign'=>function($e){$e->with('group');}, 'topic']);}, 'directed'])
            ->where('id', $id)->first();
//        return $directedAudio;
        return view('admin.data_collection.editDirected', compact('directedAudio'));
    }


    public function editSpontaneous($id){
        $dcSpontaneous = DCSpontaneous::with(['collection'=>function($e){$e->with(['language', 'district', 'collector', 'speaker',
            'taskAssign'=>function($q){$q->with('group');}]);}, 'spontaneous'])
            ->where('id', $id)->first();
//        return $dcSpontaneous;
        return view('admin.data_collection.editSpontaneous', compact('dcSpontaneous'));
    }

    public function update(Request $request, $id)
    {
        $dcSpontaneous = DCSpontaneous::findOrFail($id);
        $dcSpontaneous->approved_date =Carbon::today()->toDateTimeString();
        $dcSpontaneous->approved_by = $request->approved_by;
        $dcSpontaneous->update();

        return redirect()->route('admin.data_collections.index')->with('success', __('messages.স্বতঃস্ফূর্ত সংগৃহীত ডাটাটি সফলভাবে অনুমোদিত হয়েছে।'));
    }

    public function updateDirected(Request $request, $id){
        $dcDirectedSentence = DCDirectedSentence::findOrFail($id);
        $dcDirectedSentence->bangla = $request->bangla;
        $dcDirectedSentence->english = $request->english;
        $dcDirectedSentence->transcription = $request->transcription;
        $dcDirectedSentence->update();

        return redirect()->back()->with('success', 'Directed Sentences Collection has been Updated Successfully.');
    }

    public function updateSpontaneous(Request $request, $id)
    {

        $request->validate([
            'bangla'      => 'required',
            'english'    => 'required',
            'transcription'    => 'required',
        ]);
        $dcSpontaneous = DCSpontaneous::findOrFail($id);
        $dcSpontaneous->bangla =$request->bangla;
        $dcSpontaneous->english = $request->english;
        $dcSpontaneous->transcription = $request->transcription;
        $dcSpontaneous->update();

        return redirect()->back()->with('success', 'Spontaneous Collection has been Updated Successfully');
    }

    public function destroy($id)
    {
        AudioTrim::where('d_c_spontaneouses_id', $id)->delete();
        $dcSpontaneous= DCSpontaneous::findOrFail($id);
        $audioPath = public_path($dcSpontaneous->audio);
        if(File::exists($audioPath)) {
            File::delete($audioPath);
        }
        $dcSpontaneous->delete();
        $dataCollection= DataCollection::findOrFail($dcSpontaneous->data_collection_id);
        $dataCollection->delete();

        return redirect()->back()->with('success', __('messages.স্বতঃস্ফূর্ত সংগৃহীত ডাটাটি সফলভাবে মুছে ফেলা হয়েছে'));
    }

    public function destroyDirected($id)
    {

        AudioTrim::where('d_c_directed_sentences_id', $id)->delete();
        $dcDirectedSentence =DCDirectedSentence::findOrFail($id);
        $audioPath = public_path($dcDirectedSentence->audio);
        if(File::exists($audioPath)) {
            File::delete($audioPath);
        }
        $dcDirectedSentence->delete();
        $dcDirected =DCDirected::findOrFail($dcDirectedSentence->d_c_directed_id);
        $dcDirected->delete();
        $dataCollection= DataCollection::findOrFail($dcDirected->data_collection_id);
        $dataCollection->delete();

        return redirect()->back()->with('success', __('messages.নির্দেশিত সংগৃহীত ডাটাটি সফলভাবে মুছে ফেলা হয়েছে'));
    }

    public function directedSendToApprove($id)
    {
        $directedAudio = DCDirectedSentence::with(['dcDirected'=>function($q){
            $q->with(['collection.district','collection.language','collection.collector', 'collection.speaker', 'collection.taskAssign'=>function($e){$e->with('group');}, 'topic']);}, 'directed'])
            ->where('id', $id)->first();
        // return $directedAudio;
        return view('admin.data_approval.directed_sendToApprove', compact('directedAudio'));
    }

    public function sentToDataApproved(Request $request,$id)
    {
        // return $request->all();
// return $id;
        if ($id){
            DCDirectedSentence::where('id', $id)
                ->update(['approved_date'=>Carbon::now(), 'approved_by'=>auth()->id(), 'status'=>'1','topic_status'=>'4']);
        }/* else{
            DCSpontaneous::where('id', $request->d_c_spontaneouses_id)
                ->update(['approved_date'=>Carbon::now(), 'approved_by'=>auth()->id(), 'status'=>'1']);
        } */

        return redirect()->route('admin.directed.languages.sentence.list',['task_assign_id'=>$request->task_assign_id,'topic_id'=>$request->topic_id])
            ->with('success', 'Data Collection has been Approved');
    }
    public function directedDataRevert($id)
    {
        $directedAudio = DCDirectedSentence::with(['dcDirected'=>function($q){
            $q->with(['collection.district','collection.language','collection.collector', 'collection.speaker', 'collection.taskAssign'=>function($e){$e->with('group');}, 'topic']);}, 'directed'])
            ->where('id', $id)->first();
        // return $directedAudio;
        return view('admin.data_approval.directed_revert', compact('directedAudio'));
    }

    public function directedRevert($id){

        $revert = DCDirectedSentence::findOrFail($id);

        return response()->json([
            'revert'=>$revert,
        ], 200);
    }
    public function directedSendToRevert(Request $request){

        $trimID = $request->trimID;
       $collectorID = $request->input('collector_id');

            $audio = DCDirectedSentence::findOrFail($trimID);
            $audio->status = 2;
            $audio->comment =$request->comment;
            $audio->update();
              // Sent to user Notification

              $n_title = 'Data Reverted';
              $n_body  = 'Your Collection data is reverted';

              Notification::create([

                  'user_id'     => $collectorID,
                  'title'       => $n_title,
                  'body'        => $n_body,
                  'status'      => 0,
                  'created_by'  => Auth::user()->id
              ]);


        return redirect()->route('admin.directed.languages.sentence.list',['task_assign_id'=>$request->task_assign_id,'topic_id'=>$request->topic_id])
            ->with('success','Data has been Commented & reverted successfully ');
    }
    public function directedDataValidationRevert($id){

        $revert = DCDirectedSentence::findOrFail($id);

        return response()->json([
            'revert'=>$revert,
        ], 200);
    }
    public function directedToRevertData(Request $request){
        // return $request->all();
            $collectorID = $request->collector_id;
            $dcDirectedSentenceID=$request->dc_directed_sentence_id;

            $dcDirectedSentence = DCDirectedSentence::findOrFail($dcDirectedSentenceID);
            $dcDirectedSentence->status = 2;
            $dcDirectedSentence->validation_status = 0;
            $dcDirectedSentence->comment =$request->comment;
            $dcDirectedSentence->update();
              // Sent to user Notification

              $n_title = 'Data Reverted';
              $n_body  = 'Your Collection data is reverted';

              Notification::create([

                  'user_id'     => $collectorID,
                  'title'       => $n_title,
                  'body'        => $n_body,
                  'status'      => 0,
                  'created_by'  => Auth::user()->id
              ]);
              return redirect()->back()
        // return redirect()->route('admin.directed.languages.sentence.list',['task_assign_id'=>$request->task_assign_id,'topic_id'=>$request->topic_id])
        ->with('success','Data has been Commented & reverted successfully ');
    }
    public function directedToRevert($id){

        $revert = DCDirectedSentence::findOrFail($id);

        return response()->json([
            'revert'=>$revert,
        ], 200);
    }

    public function getDataCollectionList($lanID, $distID, $collectorID, $speakerID){

        $dataCollections = DataCollection::where('language_id', $lanID)->where('district_id', $distID)
            ->where('collector_id', $collectorID)
            ->where('speaker_id', $speakerID)
            ->with('language', 'district', 'collector', 'speaker','dcDirected.dcSentence.directed', 'dcSpontaneous.spontaneous')
            ->latest()->get();

//        dd($dataCollections->toArray());

        $firstItem = Arr::first($dataCollections, function ($value, $key) {
            return $value;
        });

        return view('admin.data_collection.collectionList', compact('dataCollections', 'firstItem'));
    }



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


    public function getTopicWiseValidation($TaskID, $topicID){
        $directedLanguages =DirectedTaskAssign::where('task_assign_id', $TaskID)
            ->where('topic_id', $topicID)
            ->with('taskAssign.validators','taskAssign.speakers','taskAssign.language','taskAssign.district', 'topic.directeds')
            ->first();
//        dd($directedLanguages->toArray());
        $districts = District::pluck('name', 'id');
        $sentences = $directedLanguages->topic->directeds->paginate(1);

        $directedAudios=DataCollection::where('task_assign_id', $TaskID)
            ->where('type_id',1)
            ->with('speaker','collector', 'dcDirected.dcSentence.validator','dcDirected.dcSentence.directed')
            ->whereHas('dcDirected', function($q) use($topicID){
                $q->where('topic_id', $topicID);
            })
            ->paginate(1);

    //    dd($directedAudios->toArray());
        return view('admin.data_collection.direct_validation',
            compact('districts','sentences','directedAudios','directedLanguages'));
    }

    public function topicWiseValidationStore(Request $request){
//            return $request->all();
        DCDirectedSentence::where('id', $request->d_c_directed_sentence_id)
            ->update(['validator_id'=>auth()->id(), 'validation_status'=>$request->validation_status,'topic_status'=>'3']);

        return redirect()->back()->with('success', __('Directed Sentence Validated Successfully'));
    }

    public function trimParentAudio ($type, $dc_sentence_id)
    {

        //    return $dcDirectedSentence = DCDirectedSentence::where('id',$dc_sentence_id)->with(['directed', 'dcDirected'])->first();
        //    return $dcDirectedSentence->directed->topics;
        if ($type == 'directed')
        {
           $audio = DCDirectedSentence::where('id',$dc_sentence_id)->with(['directed', 'dcDirected.collection.taskAssign'])->first();
        } elseif ($type == 'spontaneous')
        {
            $audio = DCSpontaneous::where('id', $dc_sentence_id)->with(['spontaneous', 'collection'])->first();
        }
        //    return $audio;
//        monu -- set url in sessions
        if (Facades\Session::has('trim_previous_url'))
        {
            Facades\Session::forget('trim_previous_url');
        }
        Facades\Session::put('trim_previous_url', url()->previous().'?di='.$dc_sentence_id);

//        monu code ends - set url in sessions
        return view('admin.data_collection.parent-trim', [
            //        'dcDirectedSentence'=> DCDirectedSentence::where('id',$dc_sentence_id)->with(['directed', 'dcDirected'])->first(),
            'audio'     => $audio,
            'type'      => $type
        ]);
    }


    public function getWordWiseDataCollection($TaskID, $topicID){

        $spontaneous =  SpontaneousTaskAssign::where('user_id', auth()->id())
            ->where('task_assign_id', $TaskID)
            ->where('spontaneous_id', $topicID)
            ->with('collector','taskAssign.speakers','taskAssign.language','taskAssign.district','spontaneous')->first();

        $districts = District::pluck('name', 'id');

        $data = [

            "task_assign_id" => $spontaneous->task_assign_id,
            "spontaneous_id" => $spontaneous->spontaneous_id,
            "language_id"    => $spontaneous->taskAssign->language_id,
            "district_id"    => $spontaneous->taskAssign->district_id,

        ];


        $spontaneousAudio = DataCollection::where('task_assign_id',$TaskID)
            ->where('type_id',2)->with('speaker', 'dcSpontaneous')
            ->whereHas('dcSpontaneous', function($q) use($topicID){
                $q->where('spontaneous_id', $topicID);
            })
            ->first();
//       dd($spontaneousAudio->toArray());
        $languageBySpeakers= DB::table('language_districts')
                    ->join('speakers', 'language_districts.id', '=', 'speakers.language_district_id')
                    ->join('districts', 'language_districts.district_id', '=' , 'districts.id')
                    ->where('language_id',$spontaneous->taskAssign->language->id)
                    ->select('language_districts.*','speakers.id as speaker_id','speakers.name as speaker_name','districts.name as district_name')
                    ->get();

        return view('admin.data_collection.data_collect_spontaneous',compact('spontaneousAudio','data','spontaneous', 'districts','languageBySpeakers'));

    }


    public function getWordWiseValidation($TaskID, $topicID){
        if (Auth::user()->hasRole('Linguist') || Auth::user()->hasRole('Validator')) {
            $spontaneous =  SpontaneousTaskAssign::where('task_assign_id', $TaskID)
                ->where('spontaneous_id', $topicID)
                ->with('taskAssign.validators','taskAssign.language','taskAssign.district','spontaneous')->first();
//            dd($spontaneous->toArray());
        }

        $districts = District::pluck('name', 'id');

        $spontaneousAudio = DataCollection::where('task_assign_id',$TaskID)
            ->where('type_id',2)->with('speaker', 'collector', 'dcSpontaneous.validator')
            ->whereHas('dcSpontaneous', function($q) use($topicID){
                $q->where('spontaneous_id', $topicID);
            })
            ->first();
//         dd($spontaneousAudio->toArray());

        return view('admin.data_collection.spont_validation',compact('spontaneousAudio','spontaneous', 'districts'));

    }

    public function wordWiseValidationStore(Request $request){
        AudioTrim::where('id', $request->audio_trim_id)
            ->update(['validator_id'=>auth()->id(), 'validation_status'=>$request->validation_status]);

        return redirect()->back()->with('success', __('messages.Validated Successfully'));
    }

    public function wordWiseApprove(Request $request){
        AudioTrim::where('id', $request->audio_trim_id)
            ->update(['approved_by'=>auth()->id(), 'status'=>'3']);

        return redirect()->back()->with('success', __('messages.Approved Successfully'));
    }


    public function submitSentence(Request $request)
    {
        // return 'yes';
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'language_id' => 'required',
                'type_id'  => 'required',
                'audio' => 'required',
                'speaker_id' => 'required',
            ]);

        $sentence_id = $request->sentence_id;
        $type        = $request->type_id;
        $dc_spontaneous_id = $request->dc_spontaneous_id;

        if ($sentence_id == !null) {

            $this->updateSubmitSentence($type,$sentence_id,$request);

            // return response()->json(['msg' => 'Data Saved Succesfully']);

        }elseif ($dc_spontaneous_id == !null) {

            $this->updateSubmitSentence($type,$dc_spontaneous_id,$request);

            return response()->json(['msg' => 'Data Saved Succesfully']);

        }
        else{

            if ($request->audio_file == !null) {

                $decoded_file = $request->audio_file;  //Decoded audio file
                $audio_parts  = explode(";base64,", $decoded_file);
                $audio_type   = explode("audio/wav", $audio_parts[0]);
                $audio_base64 = base64_decode($audio_parts[1]);
                $audio_directory = './uploads/data-collections/';
                $file_name_no_ext = 'record_'.date('D').rand(10, 100);
                $file_name = $file_name_no_ext.'.mp3';
                $record = file_put_contents($audio_directory.$file_name, $audio_base64);
                $wav_audio_url = $audio_directory.$file_name;
                $audio_re_file = $request->audio_blob;
                $audio_file = str_replace('data:audio/wav;base64,', '', $audio_re_file);
                $newfile_name = 'record_'.time().'.mp3';
                $audio_url = $audio_directory.$file_name_no_ext.'.mp3';


                /*if ($request->speaker_id == null)
                {
                    $speaker = $this->speaker($request);
                }*/
                //    ($request->speaker_id == null) ? $speaker->id : $request->speaker_id;

                $dataCollection = $this->dataCollection($request, $request->speaker_id);

                if ($request->type_id == 'directeds')
                {
                    $dcDirect = $this->dcDirect($dataCollection->id,  $request->topic_id);
                    $dcDirectSentence = $this->dcDirectSentence($request,/*  $record_length, */ $dcDirect, $audio_url, $request->directed_id, $audio_file);
                } else {
                    $dcSpont = $this->dcSpont($request, $dataCollection->id,/* $record_length, */ $audio_url, $request->spontaneous_id, $audio_file);
                }

            }else{

                $dataCollection = $this->dataCollection($request, $request->speaker_id);

                foreach ($request->file('audio') as $key => $item)
                {
                    $audio_src  = file_get_contents( $item);
                    $audio_file = base64_encode($audio_src);

                    if($request->hasFile('audio')){

                        $audioName  =   time().rand(10,1000).'.'.$item->getClientOriginalExtension();
                        $directory  =   './uploads/data-collections/';
                        $audioUrl   =   $directory.$audioName;
                        $file       = $item->move($directory, $audioName);
                    }

                    if ($request->type_id == 'directeds')
                    {
                        $dcDirect = $this->dcDirect($dataCollection->id, $request->topic_id);
                        $dcDirectSentence = $this->dcDirectSentence($request, $dcDirect, $audioUrl, $request->directed_id,$audio_file);

                    } else {

                        $dcSpont = $this->dcSpont($request, $dataCollection->id, $audioUrl, $request->spontaneous_id , $audio_file);
                    }
                }
                    // return$request->all();

                // return response()->json(['msg' => 'Data Saved Succesfully']);
            }


            // return response()->json(['msg' => 'Data Saved Succesfully']);

        }
        DB::commit();

        return response()->json([
            'msg' => 'আপনার ডাটাটি সফলভাবে সংগ্রহ হয়েছে।',
            'speaker_id'    => $request->speaker_id
        ]);

        }catch (\Throwable $th) {
            DB::rollBack();
            // return $th;

            return response()->json(['msg' => 'কিছু ভুল হয়েছে। আবার চেষ্টা করুন।']);
        }


    }


    public function updateSubmitSentence($type, $id, $request)
    {
        if ($type == 'directeds') {

            $sentence = DCDirectedSentence::find($id);
            $sentence->transcription = $request->transcription;
            $sentence->save();

            if ($request->audio_file == !null) {

                $decoded_file = $request->audio_file;  //Decoded audio file
                $audio_parts  = explode(";base64,", $decoded_file);
                $audio_type   = explode("audio/wav", $audio_parts[0]);
                $audio_base64 = base64_decode($audio_parts[1]);
                $audio_directory = './uploads/data-collections/';
                $file_name_no_ext = 'record_'.date('D').rand(10, 100);
                $file_name = $file_name_no_ext.'.mp3';
                $record = file_put_contents($audio_directory.$file_name, $audio_base64);
                $wav_audio_url = $audio_directory.$file_name;
                $audio_re_file = $request->audio_blob;
                $audio_file = str_replace('data:audio/wav;base64,', '', $audio_re_file);
                $newfile_name = 'record_'.time().'.mp3';
                $audio_url = $audio_directory.$file_name_no_ext.'.mp3';

                $ffprobe    = \FFMpeg\FFProbe::create();


                unlink($sentence->audio);
                $sentence->audio = $audio_url;
                $sentence->audio_blob = $audio_file;
                $duration=$ffprobe->format($audio_url)->get('duration');
                // $length=$duration/60;
                $sentence->audio_duration  = $duration;
                $sentence->save();

            }else{

                if ($request->file('audio') == !null) {

                    foreach ($request->file('audio') as $key => $audio_data)
                    {
                        $audio_src  = file_get_contents( $audio_data);
                        $audio_file = base64_encode($audio_src);
                        $audioName  =   time().rand(10,1000).'.'.$audio_data->getClientOriginalExtension();
                        $directory  =   './uploads/data-collections/';
                        $audioUrl   =   $directory.$audioName;
                        $file       = $audio_data->move($directory, $audioName);

                        $ffprobe    = \FFMpeg\FFProbe::create();
                        // $duration=$ffprobe->format($audioUrl)->get('duration');
                        // $length=$duration/60;
                        unlink($sentence->audio);
                        $sentence->audio = $audioUrl;
                        $sentence->audio_blob = $audio_file;
                        $duration=$ffprobe->format($audioUrl)->get('duration');
                        // $length=$duration/60;
                        $sentence->audio_duration  = $duration;
                        $sentence->save();

                    }

                }

            }

        }
        else {
            $spontaneousAudio = DCSpontaneous::findOrFail($id);
            $spontaneousAudio->bangla = $request->bangla;
            $spontaneousAudio->english = $request->english;
            $spontaneousAudio->transcription = $request->transcription;
            $spontaneousAudio->save();

            if ($request->audio_file == !null) {

                $decoded_file = $request->audio_file;  //Decoded audio file
                $audio_parts  = explode(";base64,", $decoded_file);
                $audio_type   = explode("audio/wav", $audio_parts[0]);
                $audio_base64 = base64_decode($audio_parts[1]);
                $audio_directory = './uploads/data-collections/';
                $file_name_no_ext = 'record_'.date('D').rand(10, 100);
                $file_name = $file_name_no_ext.'.mp3';
                $record = file_put_contents($audio_directory.$file_name, $audio_base64);
                $wav_audio_url = $audio_directory.$file_name;
                $audio_re_file = $request->audio_blob;
                $audio_file = str_replace('data:audio/wav;base64,', '', $audio_re_file);
                $newfile_name = 'record_'.time().'.mp3';
                $audio_url = $audio_directory.$file_name_no_ext.'.mp3';

                $ffprobe    = \FFMpeg\FFProbe::create();
                unlink($spontaneousAudio->audio);
                $spontaneousAudio->audio = $audio_url;
                $spontaneousAudio->audio_blob = $audio_file;
                $duration=$ffprobe->format($audio_url)->get('duration');
                $spontaneousAudio->audio_duration  = $duration;
                $spontaneousAudio->save();

            }else{

                if ($request->file('audio') == !null) {

                    foreach ($request->file('audio') as $key => $audio_data)
                    {
                        $audio_src  = file_get_contents( $audio_data);
                        $audio_file = base64_encode($audio_src);
                        $audioName  =   time().rand(10,1000).'.'.$audio_data->getClientOriginalExtension();
                        $directory  =   './uploads/data-collections/';
                        $audioUrl   =   $directory.$audioName;
                        $file       = $audio_data->move($directory, $audioName);

                        $ffprobe    = \FFMpeg\FFProbe::create();
                        unlink($spontaneousAudio->audio);
                        $spontaneousAudio->audio = $audioUrl;
                        $spontaneousAudio->audio_blob = $audio_file;
                        $duration=$ffprobe->format($audioUrl)->get('duration');
                        $spontaneousAudio->audio_duration  = $duration;
                        $spontaneousAudio->save();


                    }

                }

            }

        }

    }

     public function sendToApprove(Request $request){
        //            return $request->all();
                    DCDirectedSentence::where('id', $request->d_c_directed_sentence_id)
                        ->update(['approved_date'=>Carbon::now(),'approved_by'=>auth()->id(), 'status'=>$request->status]);

                return redirect()->back()->with('success', __('Directed Sentence Send to Approve Successfully'));
            }


}
