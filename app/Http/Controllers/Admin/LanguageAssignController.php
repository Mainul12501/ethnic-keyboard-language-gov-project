<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DirectedLanguage;
use App\Models\Language;
use App\Models\Spontaneous;
use App\Models\SpontaneousLanguage;
use App\Models\Topic;
use App\Models\TaskAssign;
use Illuminate\Http\Request;

class LanguageAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::withCount(['directedLanguage','spontaneousLanguage'])->get();
//        return $languages;

        return view('admin.language_assign.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages= Language::pluck('name','id');
        $directedTopics= Topic::pluck('name','id');
        $spontaneouses = Spontaneous::pluck('word', 'id');

        return view('admin.language_assign.create', compact('languages','directedTopics','spontaneouses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'language_id' => 'required',
            'topic' => 'required',
            'spontaneous' => 'required',
        ]);

        $directedLanguageExists = DirectedLanguage::where('language_id', $request->language_id)->get();
        $spontaneousLanguageExists = SpontaneousLanguage::where('language_id', $request->language_id)->get();

        if (!$directedLanguageExists && !$spontaneousLanguageExists){
            foreach ($request->topic as $topicItem){
                DirectedLanguage::create([
                    'topic_id'=>$topicItem,
                    'language_id'=>$request->language_id,
                    'created_by'=>auth()->id(),
                    'updated_by'=>0,
                ]);
            }
            foreach ($request->spontaneous as $spontaneousItem){
                SpontaneousLanguage::create([
                    'spontaneous_id'=>$spontaneousItem,
                    'language_id'=>$request->language_id,
                    'created_by'=>auth()->id(),
                    'updated_by'=>0,
                ]);
            }
        }else{
            return redirect()->route('admin.language_assigns.index')
                ->with('success', 'Language assign has been Already Exists ');
        }

        return redirect()->route('admin.language_assigns.index')
            ->with('success', 'Language assign has been created successfully ');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $languageAssign = Language::find($id);

        $directedTopics= Topic::pluck('name','id');
        $directedAssign= DirectedLanguage::where('language_id', $id)->pluck('topic_id','topic_id')->all();

        $spontaneouses = Spontaneous::pluck('word', 'id');
        $spontaneousesAssign = SpontaneousLanguage::where('language_id', $id)->pluck('spontaneous_id', 'spontaneous_id')->all();

        return view('admin.language_assign.edit', compact('languageAssign','directedTopics','spontaneouses', 'directedAssign', 'spontaneousesAssign'));

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
            'language_id' => 'required',
            'topic' => 'required',
            'spontaneous' => 'required',
        ]);

        $directedArray =[];
        $directedLanguageID = DirectedLanguage::where('language_id',$id)->get();
        if ($directedLanguageID){
            foreach ($directedLanguageID as $data){
                $directedArray[]= $data->topic_id;
            }
        }

        $spontaneousArray =[];
        $spontaneousLanguageID = SpontaneousLanguage::where('language_id',$id)->get();
        if ($spontaneousLanguageID){
            foreach ($spontaneousLanguageID as $spontaneousLanguage){
                $spontaneousArray[]= $spontaneousLanguage->spontaneous_id;
            }
        }

        foreach ($request->topic as $topicItem){
            $topicData = array(
                'topic_id' => $topicItem,
                'language_id'=>$request->language_id,
                'created_by'=>auth()->id(),
                'updated_by'=>auth()->id()

            );
            DirectedLanguage::updateOrCreate([
                'topic_id'=>$topicItem,
                'language_id'=>$request->language_id,
            ],$topicData);
        }

        foreach ($request->spontaneous as $spontaneousItem){
            $spontaneousData = array(
                'spontaneous_id'=>$spontaneousItem,
                'language_id'=>$id,
                'created_by'=>auth()->id(),
                'updated_by'=>auth()->id()
            );
            SpontaneousLanguage::updateOrCreate([
                'spontaneous_id'=>$spontaneousItem,
                'language_id'=>$request->language_id,
            ],$spontaneousData);
        }

        foreach ($directedArray as $directed){
            if (!in_array($directed, $request->topic)){
                DirectedLanguage::where('language_id',$request->language_id)->where('topic_id', $directed)->delete();
            }
        }

        foreach ($spontaneousArray as $spontaneous){
            if (!in_array($spontaneous, $request->spontaneous)){
                SpontaneousLanguage::where('language_id',$request->language_id)->where('spontaneous_id', $spontaneous)->delete();
            }
        }

        return redirect()->back()->with('success', __('messages.নির্দেশিত বাক্য এবং স্বতঃস্ফূর্ত কীওয়ার্ড সফলভাবে আপডেট করা হয়েছে।'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function languageList()
    {
        $totalLang= TaskAssign::with('language')->where('user_id', auth()->id())->distinct('language_id')->groupBy('language_id')->get();
//        return $languages;

        return view('admin.language_assign.languageList', compact('totalLang'));
    }
}
