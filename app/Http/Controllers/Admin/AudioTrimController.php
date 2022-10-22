<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AudioTrim;
//use App\Models\bash;
use App\Models\DCDirectedSentence;
use App\Models\User;
use App\Models\DCSpontaneous;
use App\Models\Notification;
use Illuminate\Http\Request;
use falahati\PHPMP3\MpegAudio;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;


class AudioTrimController extends Controller
{
    public function editTrim($id){
         $trimAudio=AudioTrim::where('id', $id)
             ->with(['dcSpontaneous.collection'=>function($e){$e->with(['language', 'district', 'collector', 'speaker',
            'taskAssign'=>function($q){$q->with('group');}]);}, 'dcSpontaneous.spontaneous'])
             ->first();
//        dd($trimAudio->toArray());
        return view('admin.Audio-trim.editTrim', compact('trimAudio'));
    }


    public function updateTrim(Request $request, $id)
    {
        $audioTrim = AudioTrim::findOrFail($id);
        $audioTrim->bangla =$request->bangla;
        $audioTrim->english = $request->english;
        $audioTrim->transcription = $request->transcription;
        $audioTrim->update();
        return redirect()->route('admin.spontaneous.trim.list',$audioTrim->d_c_spontaneouses_id)->with('success', 'Spontaneous trim has been Updated Successfully');
    }




    public function manageAudioTrim ()
    {
        $audios = [];
        $directedAudios = DCDirectedSentence::all();
        if ($directedAudios->isNotEmpty())
        {
            foreach ($directedAudios as $directedAudio)
            {
                array_push($audios, $directedAudio);
            }
        }
        $spontinoursAudios = DCSpontaneous::all();
        if ($spontinoursAudios->isNotEmpty())
        {
            foreach ($spontinoursAudios as $spontinoursAudio)
            {
                array_push($audios, $spontinoursAudio);
            }
        }
        $finalArray = array_filter($audios);
        return view('admin.Audio-trim.manage-trim',['audios' => $audios]);
    }

    public function trimAudio (Request $request)
    {

//        return $request->all();
        // $validator = Validator::make($request->all(), [
        //     'bangla' => 'required',
        //     'english' => 'required',
        //     'transcription' => 'required',
        // ]);
        $request->validate([
            'bangla' => 'required',
            // 'english' => 'required',
            'transcription' => 'required',
        ]);
//         // $decoded_file = $request->audio_file;  //Decoded audio file
//         // $audio_parts  = explode(";base64,", $decoded_file);
//         // $audio_type   = explode("audio/mp3", $audio_parts[0]);
//         // $audio_base64 = base64_decode($audio_parts[1]);
//         // $audio_directory = 'assets/trim-audio/';
//         // $file_name = 'trim_'.time().'.mp3'; // Rename the file
//         // $record = file_put_contents($audio_directory.$file_name, $audio_base64); //save file in the disk
//         // $trimAudioUrl = $audio_directory.$file_name;

//         if ($validator->passes()) {
//             $decoded_file = $request->audio_file;  //Decoded audio file
//             $audio_parts  = explode(";base64,", $decoded_file);
//             $audio_type   = explode("audio/mp3", $audio_parts[0]);
//             $audio_base64 = base64_decode($audio_parts[1]);
//             $audio_directory = 'uploads/trim-audio/';
//             $file_name = 'trim_'.time().'.mp3'; // Rename the file
//             $record = file_put_contents($audio_directory.$file_name, $audio_base64); //save file in the disk
//             $trimAudioUrl = $audio_directory.$file_name;

//             // $trimAudioUrl = 'uploads/trim-audio/'.time().'.mp3';

//             if ($request->directed_id != null)
//             {
//                 $audio = DCDirectedSentence::where('id', $request->audio_id)->first();
//                 // MpegAudio::fromFile($audio->audio)->trim($request->skip_time, $request->audio_duration)->saveFile($trimAudioUrl);

//                 $audioTrim = new AudioTrim();
//                 $audioTrim->d_c_directed_sentences_id = $audio->id;
//                 $audioTrim->audio = $trimAudioUrl;
//                 $audioTrim->bangla = isset($request->bangla) ? $request->bangla : '';
//                 $audioTrim->english = isset($request->english) ? $request->english : '';
//                 $audioTrim->transcription = isset($request->transcription) ? $request->transcription : '';
//                 $audioTrim->save();
//             } elseif ($request->spontaneous_id != null)
//             {
//                 $audio = DCSpontaneous::where('id', $request->audio_id)->first();
//                 // MpegAudio::fromFile($audio->audio)->trim($request->skip_time, $request->audio_duration)->saveFile($trimAudioUrl);
//                 $audioTrim = new AudioTrim();
//                 $audioTrim->d_c_spontaneouses_id = $audio->id;
//                 $audioTrim->audio = $trimAudioUrl;
//                 $audioTrim->bangla = isset($request->bangla) ? $request->bangla : '';
//                 $audioTrim->english = isset($request->english) ? $request->english : '';
//                 $audioTrim->transcription = isset($request->transcription) ? $request->transcription : '';
//                 $audioTrim->save();
//             }
//             return response()->json(['success'=>'Added new records.']);
//         }

// //        return response()->json(['error'=>$validator->errors()->all()]);
//         return response()->json(['error'=>$validator->errors()]);


        /*if ($request->ajax())
        {
            // return "yes";
            return json_encode('message');
        } else {
            // return "No";
            return redirect()->back()->with('message', 'Data saved successfully');
        }*/
        $decoded_file = $request->audio_file;  //Decoded audio file
        $audio_parts  = explode(";base64,", $decoded_file);
        $audio_type   = explode("audio/mp3", $audio_parts[0]);
        $audio_base64 = base64_decode($audio_parts[1]);
        $audio_directory = 'uploads/trim-audio/';
        $file_name = 'trim_'.time().'.mp3'; // Rename the file
        $record = file_put_contents($audio_directory.$file_name, $audio_base64); //save file in the disk
        $trimAudioUrl = $audio_directory.$file_name;


        if ($request->directed_id != null)
        {
            $audio = DCDirectedSentence::where('id', $request->audio_id)->first();
            // MpegAudio::fromFile($audio->audio)->trim($request->skip_time, $request->audio_duration)->saveFile($trimAudioUrl);

            $audioTrim = new AudioTrim();
            $audioTrim->d_c_directed_sentences_id = $audio->id;
            $audioTrim->audio = $trimAudioUrl;
            $audioTrim->bangla = isset($request->bangla) ? $request->bangla : '';
            $audioTrim->english = isset($request->english) ? $request->english : '';
            $audioTrim->transcription = isset($request->transcription) ? $request->transcription : '';
            $audioTrim->start_time = isset($request->start_time) ? $request->start_time : 0; //monu
            $audioTrim->save();
        } elseif ($request->spontaneous_id != null)
        {
            $audio = DCSpontaneous::where('id', $request->audio_id)->first();
            // MpegAudio::fromFile($audio->audio)->trim($request->skip_time, $request->audio_duration)->saveFile($trimAudioUrl);
            $audioTrim = new AudioTrim();
            $audioTrim->d_c_spontaneouses_id = $audio->id;
            $audioTrim->audio = $trimAudioUrl;
            $audioTrim->bangla = isset($request->bangla) ? $request->bangla : '';
            $audioTrim->english = isset($request->english) ? $request->english : '';
            $audioTrim->transcription = isset($request->transcription) ? $request->transcription : '';
            $audioTrim->start_time = isset($request->start_time) ? $request->start_time : 0; // monu
            $audioTrim->save();
        }
        if ($request->ajax())
        {
            return json_encode('message');
        } else {
            return redirect()->back()->with('message', 'Data saved successfully');
        }
    }
    public function replaceTrimAudio (Request $request)
    {

        if ($request->type == 'directed')
        {
            $decoded_file = $request->trim_value;  //Decoded audio file
            $audio_parts  = explode(";base64,", $decoded_file);
            $audio_type   = explode("audio/mp3", $audio_parts[0]);
            $audio_base64 = base64_decode($audio_parts[1]);
            $audio_directory = './uploads/data-collections/';
            $file_name = 'trim_'.time().'.mp3'; // Rename the file
            $record = file_put_contents($audio_directory.$file_name, $audio_base64); //save file in the disk
            $trimAudioUrl = $audio_directory.$file_name;

            $ffprobe    = \FFMpeg\FFProbe::create();

            $dcDirectedSentence = DCDirectedSentence::where('id', $request->audio_id)->with(['directed', 'dcDirected'])->first();
            if (file_exists($dcDirectedSentence->audio))
            {
                unlink($dcDirectedSentence->audio);
            }
            $dcDirectedSentence->audio  = $trimAudioUrl;
            $dcDirectedSentence->audio_blob     = $request->trim_value;
            $duration=$ffprobe->format($trimAudioUrl)->get('duration');
            $dcDirectedSentence->audio_duration  = $duration;
            $dcDirectedSentence->updated_at = Carbon::now();
            $dcDirectedSentence->save();
        } elseif ($request->type == 'spontaneous')
        {
//            return $request;
            $decoded_file = $request->trim_value;  //Decoded audio file
            $audio_parts  = explode(";base64,", $decoded_file);
            $audio_type   = explode("audio/mp3", $audio_parts[0]);
            $audio_base64 = base64_decode($audio_parts[1]);
            $audio_directory = 'uploads/trim-audio/';
            $file_name = 'trim_'.time().'.mp3'; // Rename the file
            $record = file_put_contents($audio_directory.$file_name, $audio_base64); //save file in the disk
            $trimAudioUrl = $audio_directory.$file_name;

            // $ffprobe    = \FFMpeg\FFProbe::create();

            $dcSpontaneous = DCSpontaneous::find($request->audio_id);
//            return $dcSpontaneous;
            if (file_exists($dcSpontaneous->audio))
            {
                unlink($dcSpontaneous->audio);
            }
            $dcSpontaneous->audio   = $trimAudioUrl;
            $dcSpontaneous->audio_blob   = $request->trim_value;
            $dcSpontaneous->save();
        }


        // return redirect()->route('admin.dashboard')->with('message', 'Audio replaced successfully.');
//        return json_encode($request->all());
//monu code starts redirect to previous page
        return Redirect::to(session()->get('trim_previous_url'))->with('message', 'Audio replaced successfully.');
        //monu code ends redirect to previous page
//        return redirect()->back()->with('message', 'Audio replaced successfully.');
    }
    public function getTrimAudio (Request $request)
    {

        if($request->ajax()){

            $audios = [];

            if ($request->type == 'directed'){
                $directedAudios = AudioTrim::where('d_c_directed_sentences_id',  $request->id)
//                ->where('status', '0')
                    ->whereIn('status', [0,2])
                    ->orderBy('start_time', 'ASC') //monu
//                    ->latest()
                    ->get();
                if ($directedAudios->isNotEmpty())
                {
                    foreach ($directedAudios as $directedAudio)
                    {
                        array_push($audios, $directedAudio);
                    }
                }
            }elseif ($request->type == 'spontaneous'){
                $spontinoursAudios = AudioTrim::where('d_c_spontaneouses_id', $request->id)->whereIn('status', [0,2])->orderBy('start_time', 'ASC')->get(); //monu
                if ($spontinoursAudios->isNotEmpty())
                {
                    foreach ($spontinoursAudios as $spontinoursAudio)
                    {
                        array_push($audios, $spontinoursAudio);
                    }
                }
            }


            $finalArray = array_filter($audios);

            return response()->json([
                'success' => true,
                'audios' => $finalArray
            ]);
        }

    }

    public function delTrimAudio ($id)
    {
        $audio = AudioTrim::findOrFail($id);
        if (file_exists($audio->audio))
        {
            unlink($audio->audio);
        }

        $audio->delete();
        return redirect()->back()->with('message', 'Audio deleted successfully');
        // return redirect()->back()->with('message', 'Audio deleted successfully');
    }
    public function trimPage ($type, $id, Request $request)
    {
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
//monu code start - set pervious url in session
        if (Session::has('spon_trim_previous_url'))
        {
            Session::forget('spon_trim_previous_url');
        }
        Session::put('spon_trim_previous_url', \url()->previous());
//        monu code end - set pervious url in session
        return view('admin.data_collection.trim', [
            'type' => $type,
            'audio' => $audio,

        ]);
    }


    public function trimApproved($type, $id, Request $request){
        if ($type == 'directed')
        {
           $audio = DCDirectedSentence::with(['dcDirected'=>function($q){
                $q->with(['collection.language','collection.district','collection.collector', 'collection.speaker', 'collection.taskAssign'=>function($e){$e->with('group');}, 'topic']);}, 'directed'])
                ->findOrFail($id);
                   // Notification to user

                   $n_title = 'Data Approved';
                   $n_body  = 'Your Collection data is approved';

                   Notification::create([

                       'user_id'     => $audio->dcDirected->collection->collector->id,
                       'title'       => $n_title,
                       'body'        => $n_body,
                       'status'      => 0,
                       'created_by'  => Auth::user()->id
                   ]);
        } elseif ($type == 'spontaneous')
        {
           $audio = DCSpontaneous::with(['collection'=>function($e){$e->with(['collector', 'speaker',
                'taskAssign'=>function($q){$q->with('group');}]);}, 'spontaneous'])
                ->findOrFail($id);
                 // Notification to user
                //  return $audio->collection->collector->id;

            $n_title = 'Data Approved';
            $n_body  = 'Your Collection data is approved';

            Notification::create([

                'user_id'     => $audio->collection->collector->id,
                'title'       => $n_title,
                'body'        => $n_body,
                'status'      => 0,
                'created_by'  => Auth::user()->id
            ]);

        }
        $trims = [];
        $directedAudios = AudioTrim::where('d_c_directed_sentences_id',  $request->id)
                ->whereIn('status', [1,2])
            ->latest()->get();
        if ($directedAudios->isNotEmpty())
        {
            foreach ($directedAudios as $directedAudio)
            {
                array_push($trims, $directedAudio);
            }
        }
        $spontinoursAudios = AudioTrim::where('d_c_spontaneouses_id', $request->id)->whereIn('status', [1,2])->latest()->get();
        if ($spontinoursAudios->isNotEmpty())
        {
            foreach ($spontinoursAudios as $spontinoursAudio)
            {
                array_push($trims, $spontinoursAudio);
            }
        }

        $trims = array_filter($trims);

        return view('admin.data_collection.trimApproved', compact('type', 'audio', 'trims'));
    }


    public function sendToPending (Request $request){

        if (empty($request->status)){
            return redirect()->back()->with('error', 'Please Select all Checkbox');
        }
        if ($request->d_c_directed_sentences_id){
            DCDirectedSentence::where('id', $request->d_c_directed_sentences_id)
                ->update(['approved_date'=>Carbon::now(), 'status'=>'0', 'approved_by'=>auth()->id()]);
                 // Notification to Admin

                 $n_title = 'New Collection Data';
                 $n_body  = 'You got new collection data';
                 $users = User::where('user_type',NULL)->orwhere( 'user_type',2)->get();
                // $users = User::role('Admin')->get();
                foreach ($users as $value){
                 Notification::create([

                    'user_id'     =>$value->id,
                     'title'       => $n_title,
                     'body'        => $n_body,
                     'status'      => 0,
                     'created_by'  => Auth::user()->id
                 ]);
                }
        }else{
             DCSpontaneous::where('id', $request->d_c_spontaneouses_id)
                ->update(['approved_date'=>Carbon::now(), 'status'=>'0', 'approved_by'=>auth()->id()]);
                 // Notification to Admin

                 $n_title = 'New Collection Data';
                 $n_body  = 'You got new collection data';
                //  Table::where('Column', Value)->where('NewColumn', Value)->get();
               $users = User::where('user_type',NULL)->orwhere( 'user_type',2)->get();

            //    return $users = User::role('Admin')->get();
            foreach ($users as $value){
                 Notification::create([

                     'user_id'     =>$value->id,
                     'title'       => $n_title,
                     'body'        => $n_body,
                     'status'      => 0,
                     'created_by'  => Auth::user()->id
                 ]);
                }
        }

        foreach ($request->status as $key => $value){
            AudioTrim::where('id', $value)->update(['status'=>'1']);
        }

        // return redirect()->route('admin.data_collections.index')
        //     ->with('success', 'Data Collection has been send for Approved');


//        monu code start - redirect to two step previous page
        return redirect(session()->get('spon_trim_previous_url'))->with('success', 'Data Collection has been send for Approved');
//        monu code end - redirect to two step previous page
//        return redirect()->back()->with('success', 'Data Collection has been send for Approved');

    }

    public function sendToApproved (Request $request){
        if (empty($request->status)){
            return redirect()->back()->with('error', 'Please Select all Checkbox');
        }
        if ($request->d_c_directed_sentences_id){
            DCDirectedSentence::where('id', $request->d_c_directed_sentences_id)
                ->update(['approved_date'=>Carbon::now(), 'approved_by'=>auth()->id(), 'status'=>'1']);
        }else{
            DCSpontaneous::where('id', $request->d_c_spontaneouses_id)
                ->update(['approved_date'=>Carbon::now(), 'approved_by'=>auth()->id(), 'status'=>'1']);
        }
        foreach ($request->status as $key => $value){
            AudioTrim::where('id', $value)->update(['status'=>'3']);
        }
        return redirect()->route('admin.data_collections.pending.list')
            ->with('success', 'Data Collection has been Approved');

    }


    public function revertTrim($id){

        $trim = AudioTrim::findOrFail($id);

        return response()->json([
            'trim'=>$trim,
        ], 200);
    }


    public function sendToRevert(Request $request){
        // return $request->all();
        $trimID = $request->input('trimID');
        $collectorID = $request->input('collector_id');

            //  $n_title = 'Data Reverted';
            //  $n_body  = 'Your data is reverted successfully';

            //  Notification::create([

            //      'user_id'     => $collectorID,
            //      'title'       => $n_title,
            //      'body'        => $n_body,
            //      'status'      => 0,
            //      'created_by'  => Auth::user()->id
            //  ]);

        $trim = AudioTrim::findOrFail($trimID);
        $trim->comment =$request->comment;
        $trim->status =2;
        $trim ->update();

        return redirect()->back()
            ->with('success','Audio Trim has been Commented successfully ');
    }


    public function getSpontaneousTrim($dcSpontanousID){
        $spontaneousTrimLists = AudioTrim::where('d_c_spontaneouses_id', $dcSpontanousID)->get();

        $firstItem = DCSpontaneous::with(['collection'=>function($e){$e->with(['language', 'district', 'collector', 'speaker',
            'taskAssign'=>function($q){$q->with('group');}]);}, 'spontaneous'])
            ->where('id', $dcSpontanousID)->first();

        return view('admin.Audio-trim.spontaneous_trim_list', compact('spontaneousTrimLists', 'firstItem'));
    }

    public function correctionDelete($type, $id, Request $request)
    {
        $spontCorrection = AudioTrim::findOrFail($id);
        $spontCorrection->delete();
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

        return view('admin.data_collection.trim', [
            'type' => $type,
            'audio' => $audio,
        ])->with('success', __('messages.টাস্ক অ্যাসাইন সফলভাবে মুছে ফেলা হয়েছে।'));
    }

    public function getAudioTrimData ($audioTrimId)
    {
        $audioTrim = AudioTrim::find($audioTrimId);
        return response()->json($audioTrim);
    }

    public function updateAudioTrim (Request $request)
    {
        $audioTrim = AudioTrim::find($request->audio_trim_id);

        $audioTrim->bangla  = $request->bangla;
        $audioTrim->english  = $request->english;
        $audioTrim->transcription  = $request->transcription;
        $audioTrim->save();
        return back()->with('success', 'content updated successfully.');
    }

}
