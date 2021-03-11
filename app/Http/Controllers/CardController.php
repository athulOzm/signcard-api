<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Carddesign;
use App\Cardtype;
use App\Card;
use Image;

class CardController extends Controller
{

    public function add(Request $request) {

        $subdomain = strtolower($request->domain);
       
        $subdomain = preg_replace('/\s+/', '-', $subdomain);

        if($request->name == ''){

            return response()->json(['validation' => 'Please enter Card Name', 'status' => false], 200);
        }
        else if(!is_null(Card::where('domain', $subdomain)->first())) {

            return response()->json(['validation' => 'This domain name already exist! Please try diffrent one.', 'status' => false], 200);
        } else if($request->design == ''){

            return response()->json(['validation' => 'Choose Card type & designs', 'status' => false], 200);
        }

        Card::create([
            'user_id'   =>  $request->user()->id,
            'carddesign_id' =>  $request->design,
            'name'      =>  $request->name,
            'domain'    =>  $subdomain
        ]);

        $cards = Card::where('user_id', $request->user()->id)->get();

        

        return response()->json(['status' => true, 'message' => 'Card created successfully', 'cards' => $cards], 200);
    }



    public function profile(Request $request){

        //var_dump($request->subdomain);

        $card = Card::where('domain', $request->subdomain)->first();

        $data['name'] = $card->name;
        $data['email'] = $card->email;
        $data['domain'] = $card->domain;
        $data['type'] = $card->design->cardtype_id;
        $data['design'] = $card->carddesign_id;
        $data['dp'] = $card->dp;
        $data['cover'] = $card->cover;

        $social = $contact = $prof = null;


        switch ($card->design->cardtype_id) {
            case 1:
                $social = $card->socialmedia->first();
                $contact = $card->contact->first();
                break;
            
            case 3:
                $social = $card->socialmedia->first();
                $contact = $card->contact->first();
                break;

            default:
                $social = $card->socialmedia->first();
                $contact = $card->contact->first();
                break;
        }
      
        return response()->json(['data' => $data, 'social'  =>  $social, 'contact' => $contact], 200);
    }


    public function show($card){

        if($res = Card::where('domain', $card)->first()):
            $res->socialmedia;
            $res->design;
            $res->contact;
            return response($res, 200);
        else: 
            return response(['msg' => 'Card not found'], 404);
        endif;
    }







    public function makeUrl(Request $request) {

        $subdomain = strtolower($request->domain);
       
        $subdomain = preg_replace('/\s+/', '-', $subdomain);
        $u = Card::where('domain', $subdomain)->first();

        if(!is_null($u) and $u->id != $request->id) {

            return response()->json(['validation' => 'This Domain name already exist! Please try diffrent one.', 'status' => false], 200);
        }

        $card = Card::find($request->id);
        if($card->user_id == $request->user()->id){

            Card::find($request->id)->update([
                'domain'    =>  $subdomain,
                'name'      =>  $request->name,
                'carddesign_id' =>  $request->design,
            ]);
        }

        $design = Carddesign::find($request->design);
        $type = $design->type;
        $card = Card::find($request->id);

        return response()->json(['status' => true, 'design' => $design, 'card' => $card, 'type'=> $type], 200);
    }


    public function fetchAddCard(){

        return response()->json(['cardtypes' => Cardtype::all(), 'carddesigns' => Carddesign::all()]);
    }


    public function all(Request $request){

        $cards = Card::where('user_id', $request->user()->id)->get();



        return response()->json(['cards' => $cards]);
    }

    public function type(Request $request){

        $design = Card::find($request->card)->design;
        $type = $design->type;

        return response()->json(['type' => $type, 'design' => $design]);
    }

    


    


    public function upddp(Request $request){

        $card = Card::find($request->id);

        if($request->user()->id == $card->user_id){


            $rname = $card->domain.rand(245, 255);
            Image::make($request->dp)
            ->save(storage_path('app/public/profile').'/'.$rname.'.jpg');


            if ($request->type == 'dp') {
                $card = Card::find($request->id)->update([
                    'dp' => $rname.'.jpg'
                ]);
            } else {
                $card = Card::find($request->id)->update([
                    'cover' => $rname.'.jpg'
                ]);
            }

            $card = Card::find($request->id);

            return response()->json(['response' => true, 'card' => $card]);

        }
        //$imagename = 'http://reactjsauthwithlaravel.test/server/storage/files/'.$rname.'.jpg';
        //$imagename2 = 'http://10.0.2.2/reactJsAuthWithLaravel/server/storage/files/'.$rname.'.jpg';
    }


    


}
