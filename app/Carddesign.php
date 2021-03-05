<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carddesign extends Model
{
    public function type()
    {
        return $this->belongsTo('App\Cardtype', 'cardtype_id', 'id');
    }
}
