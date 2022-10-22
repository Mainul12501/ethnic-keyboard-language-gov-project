<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Spontaneous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpontaneousController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spontaneouses = Spontaneous::latest()->get();

        return view('admin.spontaneous.index', compact('spontaneouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'word'  => 'required',
        ]);

        foreach ($request->get('word') as $wordItem){
            $spontaneous = new Spontaneous;
            $spontaneous->word = $wordItem;
            $spontaneous->created_by = auth()->id();
            $spontaneous->updated_by = 0;
            $spontaneous->save();
        }

        return redirect()->route('admin.spontaneouses.index')
            ->with('success', __('messages.স্বতঃস্ফূর্ত কীওয়ার্ড সফলভাবে তৈরি করা হয়েছে৷'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Spontaneous  $spontaneous
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $spontaneous = Spontaneous::findOrFail($id);

        return view('admin.spontaneous.show', compact('spontaneous'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Spontaneous  $spontaneous
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $spontaneous = Spontaneous::find($id);


        return response()->json([
            'spontaneous'=>$spontaneous,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Spontaneous  $spontaneous
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Spontaneous $spontaneous)
    {
        //
    }


    public function spontaneousUpdate(Request $request){
        $request->validate([
            'word'  => 'required',
        ]);

        $spontaneousID = $request->input('spontaneousID');

        $spontaneous = Spontaneous::find($spontaneousID);
        $spontaneous->word =$request->word;
        $spontaneous->updated_by = auth()->id();
        $spontaneous ->update();

        return redirect()->route('admin.spontaneouses.index')
            ->with('success','স্বতঃস্ফূর্ত কীওয়ার্ড সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Spontaneous  $spontaneous
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spontaneous $spontaneous)
    {
        //
    }
}
