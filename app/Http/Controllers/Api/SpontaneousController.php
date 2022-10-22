<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpontaneousResource;
use App\Models\Spontaneous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class SpontaneousController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $spontaneouses = Spontaneous::orderBy('id', 'DESC')->paginate(5);

            if ($spontaneouses->isEmpty()){
                return response([
                    'data'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
               'data' => $spontaneouses,
               'message' => 'Spontaneous List',
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
        try {

            $validator = Validator::make($request->all(), [
                'word'  => 'required',
                'english' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'message'=>'Validator Error',
                    'data'=>$validator->errors(),
                    'status'=>422
                ]);
            }

            /*$spontaneous = new Spontaneous;
            $spontaneous->word = $request->word;
            $spontaneous->bangla = $request->bangla;
            $spontaneous->language_id = $request->language_id;
            $spontaneous->english = $request->english;
            $spontaneous->created_by = auth()->id();
            $spontaneous->updated_by = 0;
            $spontaneous->save();*/

            foreach ($request->get('word') as $key=> $wordItem){
                $spontaneous = new Spontaneous;
                $spontaneous->word = $wordItem;
                $spontaneous->bangla = $wordItem;
                $spontaneous->english = $request['english'][$key];
                $spontaneous->created_by = auth()->id();
                $spontaneous->updated_by = 0;
                $spontaneous->save();
            }

            return response()->json([
                'data'=> new SpontaneousResource($spontaneous),
               'message'=> 'Spontaneous has been created Successfully',
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
     * @param  \App\Models\Spontaneous  $spontaneous
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $spontaneous = Spontaneous::find($id);
            if (is_null($spontaneous)){
                return response([
                    'data'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
               'data'=>$spontaneous,
               'message'=> 'spontaneous single info',
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
     * @param  \App\Models\Spontaneous  $spontaneous
     * @return \Illuminate\Http\Response
     */
    public function edit(Spontaneous $spontaneous)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Spontaneous  $spontaneous
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {

            $validator = Validator::make($request->all(), [
                'word'  => 'required',
                'phonetic' => 'required',
                'english' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'message'=>'Validator Error',
                    'data'=>$validator->errors(),
                    'status'=>422
                ]);
            }
            $spontaneous = Spontaneous::find($id);
            $spontaneous->word =$request->word;
            $spontaneous->phonetic =$request->phonetic;
            $spontaneous->bangla =$request->word;
            $spontaneous->english =$request->english;
            $spontaneous->updated_by = auth()->id();
            $spontaneous ->update();


            return response()->json([
                'data'=> new SpontaneousResource($spontaneous),
                'message'=> 'Spontaneous has been Updated Successfully',
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
     * @param  \App\Models\Spontaneous  $spontaneous
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spontaneous $spontaneous)
    {
        //
    }
}
