<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLanuguageRequest;
use App\Models\DirectedLanguage;
use App\Models\District;
use App\Models\Language;
use App\Models\LanguageDistrict;
use App\Models\SubLanguage;
use Illuminate\Http\Request;
use Session;
use function PHPUnit\Framework\isEmpty;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages= Language::with('subLanguages', 'languageDistricts')->latest()->get();

        return view('admin.language.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts = District::all();

        return view('admin.language.create', compact('districts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLanuguageRequest $request)
    {
        $language = new Language;
        $language->name =$request->name;
        $language->status = 1;
        $language->created_by=auth()->id();
        $language->updated_by=0;
        $language->save();

        foreach ($request->sub_language as $subLanguageItem){
            SubLanguage::create([
                'language_id'=>$language->id,
                'sub_name'=>$subLanguageItem,
            ]);
        }

        foreach ($request->district_id as $districtItem){
            LanguageDistrict::create([
                'language_id'=>$language->id,
                'district_id'=>$districtItem,
            ]);
        }


        return redirect()->route('admin.languages.index')
            ->with('success', __('messages.ভাষা সফলভাবে তৈরি করা হয়েছে।'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
//        $languageDistcricts = LanguageDistrict::where('language_id', $language->id)->get()->toArray();
        $languageDistcricts = LanguageDistrict::where('language_id', $language->id)->pluck('district_id', 'district_id')->toArray();
         $subLanguages = SubLanguage::where('language_id', $language->id)->pluck('sub_name', 'id')->toArray();
//        dd($languageDistcricts);
        $districts = District::all();

        return view('admin.language.edit', compact('language','languageDistcricts', 'districts', 'subLanguages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLanuguageRequest $request, Language $language)
    {
        // return $request->all();
//        return $request->district_id;
//        return $request->sub_language;
        $language->name =$request->name;
        $language->status = 1;
        $language->updated_by=auth()->id();
        $language->update();

        $dataArray =[];
        $ids = LanguageDistrict::where('language_id',$language->id)->get();
        if ($ids){
            foreach ($ids as $data){
                $dataArray[]= $data->district_id;
            }
        }
        $subLanArr=[];
         $subIDs = SubLanguage::where('language_id',$language->id)->get();
        if ($subIDs){
            foreach ($subIDs as $subID){
                $subLanArr[]= $subID->sub_name;
            }
        }
        if($request->sub_language )
        {
            foreach ($request->sub_language as $key =>$subLanguage){
                $data = array(
                    'language_id'=>$language->id,
                    'sub_name'=>$subLanguage
                );
                SubLanguage::updateOrCreate(
                    ['language_id'=>$language->id, 'sub_name'=>$subLanguage],
                    $data
                );
            }
        }

        foreach ($subLanArr as $subName){
            if (!in_array($subName, $request->sub_language)){
                SubLanguage::where('language_id',$language->id)->where('sub_name', $subName)->delete();
            }
        }

        foreach ($request->district_id as $key =>$districtItem){
            $data = array(
              'language_id'=>$language->id,
              'district_id'=>$districtItem
            );
            LanguageDistrict::updateOrCreate(
                ['language_id'=>$language->id, 'district_id'=>$districtItem],
                $data
            );
        }
        foreach ($dataArray as $data){
            if (!in_array($data, $request->district_id)){
                LanguageDistrict::where('language_id',$language->id)->where('district_id', $data)->delete();
            }
        }

        return redirect()->route('admin.languages.index')->with('success', __('messages.ভাষা সফলভাবে আপডেট করা হয়েছে।'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        if ($language->directedLanguage()->count() || $language->spontaneousLanguage()->count()){
            return back()->with(['error'=>'Cannot delete, Language has Directed or Spontaneous Record']);
        }
        $language->delete();
       LanguageDistrict::where('language_id', $language->id)->delete();
       SubLanguage::where('language_id', $language->id)->delete();


        return redirect()->back()->with('success', __('messages.ভাষা সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
