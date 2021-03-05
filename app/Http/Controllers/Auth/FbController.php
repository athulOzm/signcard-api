<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;



use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class FbController extends Controller
{
    public function register(Request $request){ 

        $client = new Client(['base_uri' => 'https://graph.facebook.com']);
         //response = $client->request('GET', '/api/users?page=2');

        


        $response = $client->request('GET', '/debug_token?input_token='.$request->accessToken.
        '&access_token=607506983220036|bb1eed6403feb5d36aa1eee0443eaa19');

        $payload = json_decode($response->getBody()->getContents());

        //var_dump($payload->data->user_id);

        if($request->fbid == $payload->data->user_id){
        
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
                'provider'      =>  'fb'
            ]);

            }


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

            
        
        return response()->json( [ 'status' => true, 'user' => $user ] );

    }
}


