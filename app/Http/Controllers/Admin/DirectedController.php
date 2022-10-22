<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDirectedRequest;
use App\Models\Directed;
use App\Models\Language;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Imports\TopicsImport;
use App\Imports\DirectedsImport;
use Maatwebsite\Excel\Facades\Excel;

class DirectedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $directedTopics = Topic::orderBy('id', 'desc')->get();

        return view('admin.directed.index', compact('directedTopics'));
    }

    public function index_old(Request $request)
    {
        //return $request->search;
        $directeds = Topic::withCount('topicAssignLanguage')->with('directeds', 'topicAssignLanguage.language')->latest()->paginate(10);
        if($request->search != ''){
            /*$topic = Topic::where('name', $request->search)->first();
            $topicID= $topic->id;*/
            $directeds = Topic::with(['directeds' => function($query) use($request) {
                $query->where('sentence', 'LIKE','%'.$request->search.'%')
                    ->orWhere('english', 'LIKE','%'.$request->search.'%');
                /*->orWhere('topic_id', 'LIKE','%'.$topicID.'%');*/
            }])
                ->whereHas('directeds',  function ($q) use ($request) {
                    $q->where('sentence', 'LIKE','%'.$request->search.'%')
                        ->orWhere('english', 'LIKE','%'.$request->search.'%');
                    /*->orWhere('topic_id', 'LIKE','%'.$topicID.'%');*/
                })
                ->latest()->paginate(10);
        }


        /*return view('admin.directed.index_old', compact('directeds'));*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "name.*"    => "required|string",
        ]);

        if ($validator->passes()){

            foreach ($request->get('name') as $key=> $topicItem){
                $topic = new Topic;
                $topic->name = $topicItem;
                $topic->created_by = auth()->id();
                $topic->updated_by = 0;
                $topic->save();
            }

            return redirect()->route('admin.directeds.index')
                ->with('success', __('messages.নির্দেশিত বাক্য সফলভাবে তৈরি করা হয়েছে৷'));
        }else{
            return redirect()->back()->withErrors($validator);// ['error'=>$validator->errors()->all()];
        }

    }
    public function store_old(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name"    => "required|string",
            "sentence.*"  => "required|string",
            "english.*"  => "required|string",
        ]);

        if ($validator->passes()){
            $topic = new Topic;
            $topic->name = $request->name;
            $topic->created_by = auth()->id();
            $topic->updated_by = 0;
            $topic->save();

            foreach ($request->get('sentence') as $key=> $sentenceItem){
                $sentence = new Directed;
                $sentence->topic_id= $topic->id;
                $sentence->sentence= $sentenceItem;
                $sentence->english= $request['english'][$key];
                /*$sentence->transcription= $request['transcription'][$key];*/
                $sentence->created_by = auth()->id();
                $sentence->updated_by = 0;
                $sentence->save();
            }

            /*return redirect()->route('admin.directeds.index')
                ->with('success', __('messages.নির্দেশিত বাক্য সফলভাবে তৈরি করা হয়েছে৷'));*/
        }else{
           /* return redirect()->back()->withErrors($validator);*/// ['error'=>$validator->errors()->all()];
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Directed  $directed
     * @return \Illuminate\Http\Response
     */
    public function show(Directed $directed)
    {
        $directed = Directed::with('topics')->findOrFail($directed->id);

        return view('admin.directed.show', compact('directed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {
        $topic = Topic::findOrFail($id);

        return response()->json([
            'topic' => $topic,
        ], 200);

    }
   /* public function edit_old(Directed $directed)
    {
        $topic = Topic::where('id', $directed->topic_id)->get();


        return response()->json([
            'directed' => $directed,
            'topic' => $topic,
        ], 200);

    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Directed  $directed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Directed $directed)
    {
        $request->validate([
            'name'      => 'required|string',
            'sentence'  => 'required',
            'english' => 'required',
        ]);


    }


    public function directedUpdate(Request $request){

        $validator = Validator::make($request->all(), [
            "name"    => "required|string",
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $topicID = $request->topic_id;
        $topic =  Topic::find($topicID);
        $topic->name = $request->name;
        $topic->updated_by = auth()->id();
        $topic->update();

        return redirect()->route('admin.directeds.index')->with('success', __('messages.নির্দেশিত বাক্য সফলভাবে আপডেট করা হয়েছে।'));

    }



    public function destroy($id)
    {
        Directed::where('topic_id', $id)->delete();
        $topic =Topic::findOrFail($id);
        $topic->delete();

        return redirect()->back()->with('success', __('messages.নির্দেশিত বাক্য সফলভাবে মুছে ফেলা হয়েছে।'));
    }

    public function fileImportExport()
    {
       return view('file-import');
    }


    public function fileImport(Request $request)
    {
        Excel::import(new TopicsImport, $request->file('file'));
        return back();
    }

    public function directedFileImportExport()
    {
       return view('directed-file-import');
    }


    public function directedFileImport(Request $request)
    {
        Excel::import(new DirectedsImport, $request->file('file'));
        return back();
    }
}
