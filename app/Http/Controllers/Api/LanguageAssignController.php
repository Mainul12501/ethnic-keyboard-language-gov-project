<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Directed;
use App\Models\DirectedLanguage;
use App\Models\Language;
use App\Models\SpontaneousLanguage;
use App\Models\Topic;
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
        try {

            $languages = Language::withCount(['directedLanguage','spontaneousLanguage'])->orderBy('id', 'DESC')->paginate(5);

            if ($languages->isEmpty()){
                return response([
                    'data'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'data' => $languages,
                'message' => 'Assign Language List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'data'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
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
        //
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
        //
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


    public function getDirectedLanguageTopic($id){
        try {

            $directeds = DirectedLanguage::with('topics')->where('language_id', $id)->orderBy('id', 'DESC')->get('topic_id', 'id');
            if ($directeds->isEmpty()){
                return response([
                    'data'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'data' => $directeds,
                'message' => 'Directed language Topic List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'data'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
    }


    public function getDirectedLanguageList( $id){
        try {

            $directeds = Directed::where('topic_id', $id)->orderBy('id', 'DESC')->get();
            if ($directeds->isEmpty()){
                return response([
                    'data'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'data' => $directeds,
                'message' => 'Directed List by topic',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'data'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
    }

    public function getSpontaneousLanguageList($id){

        try {

            $spontaneouses = SpontaneousLanguage::with('spontaneous')->where('language_id', $id)->orderBy('id', 'DESC')->get('spontaneous_id', 'id');
            if ($spontaneouses->isEmpty()){
                return response([
                    'data'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'data' => $spontaneouses,
                'message' => 'Spontaneous language  List',
                'status' => 200
            ]);

        }catch (\Exception $e){
            return response([
                'data'=>'',
                'message'=>$e->getMessage(),
                'status'=> 500
            ]);
        }
    }
}
