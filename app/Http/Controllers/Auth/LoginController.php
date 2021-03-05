<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function userlogin(Request $request){

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            $user = Auth::user();

            $token                  =       $user->createToken('token')->accessToken;
            $success['success']     =       true;
            $success['message']     =       "Success! you are logged in successfully";
            $success['token']       =       $token;
            $success['user']       =        $user;

            return response()->json(['status' => true, 'data' => $success]);


        } else{
            return response()->json(['status' => false, 'validation' => 'Invalid login, Please try again']);
        }
    }


}
