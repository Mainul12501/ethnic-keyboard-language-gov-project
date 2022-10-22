<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpontaneousResource;
use App\Models\Directed;
use App\Models\Language;
use App\Models\Spontaneous;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DirectedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $directeds = Topic::with('directeds')->orderBy('id', 'DESC')->paginate(5);

            if ($directeds->isEmpty()){
                return response([
                    'data'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'data' => $directeds,
                'message' => 'Directed List',
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name'      => 'required|string',
                'sentence'  => 'required',
                'english' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'message'=>'Validator Error',
                    'data'=>$validator->errors(),
                    'status'=>422
                ]);
            }

            $topic = new Topic;
            $topic->name = $request->name;
            $topic->created_by = auth()->id();
            $topic->updated_by = 0;
            $topic->save();

            foreach ($request->get('sentence') as $key=> $sentenceItem){
                $directed = new Directed;
                $directed->topic_id= $topic->id;
                $directed->sentence= $sentenceItem;
                $directed->bangla= $sentenceItem;
                $directed->english= $request['english'][$key];
                $directed->created_by = auth()->id();
                $directed->updated_by = 0;
                $directed->save();
            }

            return response()->json([
                'data'=> $directed,
                'message'=> 'Directed has been created Successfully',
                'status'=> 200
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
     * Display the specified resource.
     *
     * @param  \App\Models\Directed  $directed
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $directed = Directed::find($id);
            if (is_null($directed)){
                return response([
                    'data'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            $topic = Topic::where('id', $directed->topic_id)->get();

            return response([
                'data'=>$directed,
                'topic'=>$topic,
                'message'=> 'Directed single info',
                'status' =>200
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Directed  $directed
     * @return \Illuminate\Http\Response
     */
    public function edit(Directed $directed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Directed  $directed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'sentence'  => 'required',
                'english' => 'required',
                'phonetic' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'message'=>'Validator Error',
                    'data'=>$validator->errors(),
                    'status'=>422
                ]);
            }

            $directed = Directed::find($id);
            $directed->sentence =$request->sentence;
            $directed->phonetic =$request->phonetic;
            $directed->bangla =$request->sentence;
            $directed->english =$request->english;
            $directed->updated_by = auth()->id();
            $directed->update();

          /*  $topic = Topic::find($directed->topic_id);
            $topic->name =$request->name;
            $topic->update();*/


            return response()->json([
                'data'=> $directed,
                'message'=> 'Directed has been Updated Successfully',
                'status'=> 200
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Directed  $directed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Directed $directed)
    {
        //
    }
}
