<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Carddesign;

class Cardtype extends Model
{
    public function designs()
    {
        return $this->hasMany(Carddesign::class);
    }
}
