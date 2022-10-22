<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GetProfileResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use File;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password'=>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validator Error',
                'data'=>$validator->errors()
            ],422);
        }

        $credential = $request->only('email','password');
        $user = Auth::user();
        if(Auth::attempt($credential)){
            $user = Auth::user();
            $data['access_token']= $user->createToken('accessToken')->plainTextToken;
            return response()->json([
                'message'=>'Login Successfully',
                'data'=>$data,
                'userData'=>new GetProfileResource($user)
            ],200);
        }else{
            return response()->json([
                'message'=> 'These credentials do not match our records'
            ],401);
        }
    }

    public function updateProfile(Request  $request){
        try {
            $validator = Validator::make($request->all(), [
                'name'      => 'required|string',
                'email'     => ['required', Rule::unique('users')->ignore(Auth::id())],
                'phone'    => ['required','regex:/(01)[0-9]{9}/', 'min:11', 'max:11', Rule::unique('users', 'phone')->ignore(Auth::id())],
            ]);

            if($validator->fails()){
                return response()->json([
                    'message'=>'Validator Error',
                    'data'=>$validator->errors(),
                    'status'=>422
                ]);
            }

            $user = Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if(request()->hasFile('avatar') && request('avatar') != ''){
                $imagePath = public_path($user->avatar);

                if(File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                $avatar_image = $request->avatar;
                $avatar_image_new_name = time() . $avatar_image->getClientOriginalName();
                $avatar_image->move('uploads/users', $avatar_image_new_name);
                $user->avatar = 'uploads/users/' . $avatar_image_new_name;
            }
            $user->update();

            return response([
                'data'=>new GetProfileResource($user),
                'message'=> 'Profile has been Updated Successfully',
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


    public function updatePassword(Request  $request){

        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8|confirmed',
                'password_confirmation'     => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'message'=>'Validator Error',
                    'data'=>$validator->errors(),
                    'status'=>422
                ]);
            }

            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->update();

            return response([
                'data'=>new GetProfileResource($user),
                'message'=> 'Password has been Updated Successfully',
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

    public function submitForgetPasswordForm(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
            ]);

            if($validator->fails()){
                return response()->json([
                    'message'=>'Validator Error',
                    'data'=>$validator->errors(),
                    'status'=>422
                ]);
            }

            $token = Str::random(64);

           $reset = DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            return response([
                'data'=>$reset,
                'message'=> 'Reset password link sent on your mail.',
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


    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message'=> 'Token deleted Successfully'
        ], 200);
    }



    public function getProfile(){
        try {
            $user = Auth::user();
            if (is_null($user)){
                return response([
                    'data'=>'',
                    'message'=>'No data Found',
                    'status'=>200
                ]);
            }

            return response([
                'data'=>new GetProfileResource($user),
                'message'=> 'User Profile info',
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
}
