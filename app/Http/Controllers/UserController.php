<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Card;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Image;



class UserController extends Controller
{
    public function store(Request $request){

        //return response()->json($request);

        $validation  =   Validator::make($request->all(), [

            'name'              =>      'required|min:3',
            //'email'             =>      'required|email|unique:users',
            'password'          =>      'required|alpha_num|min:5',
            'confirm_password'  =>      'required|same:password'
        ]);

        if($validation->fails()) {
            return response()->json(['status' => false, 'validation' => $validation->errors()]);
        }

        if(!is_null(User::where('email', $request->email)->first())) {

            $msg = new \stdClass();
            $msg->email = 'email alreday there!---'.$request->email;
            
            return response()->json(['status' => false, 'validation' => $msg]);
        }
            




        User::create([
            'name'              =>      $request->name,
            'email'             =>      $request->email,
            'password'          =>      Hash::make($request->password)
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
        
        //return response()->json( [ 'status' => true, 'user' => $user ] );

    }



    public function upload(Request $request){

        $rname = rand(24525, 25545);

        Image::make($request->file)
            ->save(storage_path('app/public/profile').'/'.$rname.'.jpg');


        $imagename = 'http://reactjsauthwithlaravel.test/server/storage/files/'.$rname.'.jpg';
        $imagename2 = 'http://10.0.2.2/reactJsAuthWithLaravel/server/storage/files/'.$rname.'.jpg';


        return response()->json(['response' => true, 'image' => $imagename, 'image2' => $imagename2]);
    }


    public function get(Request $request){

        //var_dump($request->subdomain);

        $user = Card::where('nam', $request->subdomain)->first();

        $success['name'] = $user->name;
        $success['email'] = $user->email;
        $success['domain'] = $user->domain;

      
        return response()->json(['data' => $success], 200);
    }


    










}
