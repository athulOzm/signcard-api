<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contact;
use App\Socialmedia;

class Card extends Model
{
    protected $guarded = [];



    public function design()
    {
        return $this->belongsTo('App\Carddesign', 'carddesign_id', 'id');
    }

    public function contact(){

        return $this->hasMany(Contact::class);
    }

    public function socialmedia(){

        return $this->hasMany(Socialmedia::class);
    }
}
