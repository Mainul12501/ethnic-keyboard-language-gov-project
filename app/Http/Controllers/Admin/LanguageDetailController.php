<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DirectedLanguage;
use App\Models\Language;
use App\Models\LanguageDirect;
use App\Models\LanguageSpontaneou;
use App\Models\SpontaneousLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class LanguageDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::withCount(['directedLanguage','spontaneousLanguage'])->paginate(5);

        return view('admin.language_detail.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = Language::all();

        return view('admin.language_detail.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dd($request->all());
        $request->validate([
            'subject'      => 'required|string',
            'sentence'  => 'required',
            'word' => 'required',
            'language_id'   => 'required',
        ]);

        foreach ($request->get('sentence') as $sentenceItem){
            $sentence = new DirectedLanguage;
            $sentence->subject= $request->subject;
            $sentence->language_id= $request->language_id;
            $sentence->sentence= $sentenceItem;
            $sentence->save();
        }
        foreach ($request->get('word') as $wordItem){
            $word = new SpontaneousLanguage;
            $word->language_id= $request->language_id;
            $word->word= $wordItem;
            $word->save();
        }

        return redirect()->route('admin.language_details.index')
            ->with('success', 'Language has been created successfully ');

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
    public function edit( $id)
    {
        $language= Language::find($id);
        $directedLanguages= DirectedLanguage::where('language_id', $id)->get( ['id','subject','sentence']);
        $spontaneousLanguages= SpontaneousLanguage::where('language_id', $id)->get(['id', 'word']);

        return view('admin.language_detail.edit', compact('language','directedLanguages', 'spontaneousLanguages'));

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
        //
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
}
