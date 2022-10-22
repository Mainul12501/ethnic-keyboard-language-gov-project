<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Directed;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DirectedSentenceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($topicID){
        $topic='';
        $directedSentences = Directed::with('topics')
            ->where('topic_id', $topicID)
            ->orderBy('id', 'asc')
            ->get();

        if ($directedSentences->isEmpty()){
            $topic=Topic::where('id', $topicID)->first();
        }
         $firstItem = Arr::first($directedSentences, function ($value, $key) {
            return $value;
        });

        return view('admin.directed_sentence.index', compact('directedSentences', 'firstItem', 'topic'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($topicID)
    {
        $topic = Topic::where('id', $topicID)->first();

        return view('admin.directed_sentence.create', compact('topic'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "sentence.*"  => "required|string",
            // "english.*"  => "required|string",
        ]);

        if ($validator->passes()){
            foreach ($request->get('sentence') as $key=> $sentenceItem){
                $sentence = new Directed;
                $sentence->topic_id= $request->topic_id;
                $sentence->sentence= $sentenceItem;
                $sentence->english= $request['english'][$key];
                $sentence->created_by = auth()->id();
                $sentence->updated_by = 0;
                $sentence->save();
            }

            return redirect()->route('admin.directed_sentence.index', $request->topic_id)
                ->with('success', __('messages.নির্দেশিত বাক্য সফলভাবে তৈরি করা হয়েছে৷'));

        }else{
             return redirect()->back()->withErrors($validator);// ['error'=>$validator->errors()->all()];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $directedSentence = Directed::with('topics')->findOrFail($id);

        return  view('admin.directed_sentence.edit', compact('directedSentence'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "sentence"  => "required|string",
            "english"  => "required|string",
        ]);

        $directedSentence = Directed::findorFail($id);
        $directedSentence->topic_id= $request->topic_id;
        $directedSentence->sentence= $request->sentence;
        $directedSentence->english= $request->english;
        $directedSentence->update();
        return redirect()->route('admin.directed_sentence.index', $request->topic_id)
            ->with('success', __('messages.নির্দেশিত বাক্য সফলভাবে আপডেট করা হয়েছে।'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $directed =Directed::findOrFail($id);
        $directed->delete();

        return redirect()->back()->with('success', __('messages.নির্দেশিত বাক্য সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
