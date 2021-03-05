<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;


use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function register(Request $request){

        

     
        $client = new \Google_Client(['client_id' => '147638058145-o07vjmjq88qtiqoo7impjel6in36amgd.apps.googleusercontent.com']);  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken($request->tokenId);


        if ($payload) {


            if(!is_null($user = User::where('email', $request->email)->first())) {
                if(Auth::loginUsingId($user->id, true)){

                    $user = Auth::user();
                    $token                  =       $user->createToken('token')->accessToken;
                    $success['success']     =       true;
                    $success['message']     =       "Success! you are logged in successfully";
                    $success['token']       =       $token;
                    $success['user']       =        $user;
        
                    return response()->json(['status' => true, 'data' => $success]);
                } else{
                    return response()->json(['status' => false, 'validation' => 'Invalid login..., Please try again']);
                }
            }


            User::create([
                'name'          =>  $request->name,
                'email'         =>  $request->email,
                'accesstoken'   =>  $request->accessToken,
                'provider'      =>  'google'
            ]);


            if(!is_null($user = User::where('email', $request->email)->first())) {
                if(Auth::loginUsingId($user->id, true)){
                    
                    $user = Auth::user();
                    $token                  =       $user->createToken('token')->accessToken;
                    $success['success']     =       true;
                    $success['message']     =       "Success! you are logged in successfully";
                    $success['token']       =       $token;
                    $success['user']        =       $user;
        
                    return response()->json(['status' => true, 'data' => $success]);
                } else{
                    return response()->json(['status' => false, 'validation' => 'Invalid login, Please try again']);
                }
            }

            return response()->json('valid token');
            die();

        } else {
            return response()->json(['status' => false, 'validation' => $validation->errors()]);
        }


        // $token = $request->get('token');
        // $loginRequest = LoginRequest::where('token', $token);
        // Auth::loginUsingId($loginRequest->user_id);

        

        

        

        // $user = User::create([
        //     'name'              =>      $request->name,
        //     'email'             =>      $request->email,
        //     'password'          =>      Hash::make($request->password)
        // ]);
        
        return response()->json( [ 'status' => true, 'user' => $user ] );

    }
}