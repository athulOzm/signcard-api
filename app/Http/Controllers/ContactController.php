<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Contact;
use App\Card;

class ContactController extends Controller
{   
    //upd contact
    public function updcontact(Request $request){

        $card = Card::find($request->id);
        if($request->user()->id == $card->user_id){

            if($card->contact->isNotEmpty()){
                
                Contact::find($card->contact->first()->id)->update([
                    'card_id'   => $request->id,
                    'place' =>  $request->place,
                    'address'   =>  $request->address,
                    'mob'   =>  $request->mob,
                    'tel'   =>  $request->tel,
                    'email' =>  $request->email
                ]);
            } else {

                Contact::create([
                    'card_id'   => $request->id,
                    'place' =>  $request->place,
                    'address'   =>  $request->address,
                    'mob'   =>  $request->mob,
                    'tel'   =>  $request->tel,
                    'email' =>  $request->email
                ]);
            }

            return response()->json(true, 200);
            
        }

    }


    // fetch contact
    public function contact(Request $request){

        $contact = Card::find($request->card)->contact;
        if ($contact->isEmpty()) {
            return response()->json(['contact' => false], 200);
        } else{
            return response()->json(['contact' => $contact->first()], 200);
        }
    }
}
