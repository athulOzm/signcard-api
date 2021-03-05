<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Card;
use App\Socialmedia;

class SocialmediaController extends Controller
{
    //fetch social media
    public function socialmedia(Request $request){

        $socialmedia = Card::find($request->card)->socialmedia;
        if ($socialmedia->isEmpty()) {
            return response()->json(['socialmedia' => false], 200);
        } else{
            return response()->json(['socialmedia' => $socialmedia->first()], 200);
        }
    }


    //upd sm
    public function updsocialmedia(Request $request){

        $card = Card::find($request->id);
        if($request->user()->id == $card->user_id){

            if($card->socialmedia->isNotEmpty()){
                
                Socialmedia::find($card->socialmedia->first()->id)->update([
                    'fb'   => $request->fb,
                    'insta' =>  $request->inst,
                    'twitter'   =>  $request->twitter,
                    'in'   =>  $request->lin,
                    'wt'   =>  $request->wt,
                    'reddit' =>  $request->reddit,
                    'podcasts'  =>  $request->podcasts,
                    'youtube'   =>  $request->youtube
                ]);
            } else {

                Socialmedia::create([
                    'card_id'   => $request->id,
                    'fb'   => $request->fb,
                    'insta' =>  $request->inst,
                    'twitter'   =>  $request->twitter,
                    'in'   =>  $request->lin,
                    'wt'   =>  $request->wt,
                    'reddit' =>  $request->reddit,
                    'podcasts'  =>  $request->podcasts,
                    'youtube'   =>  $request->youtube
                ]);
            }

            return response()->json(true, 200);
            
        }
    }


}
