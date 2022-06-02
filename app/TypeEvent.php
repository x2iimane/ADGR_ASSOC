<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeEvent extends Model
{
    public function events(){
        return $this->hasMany("App\Evenement");
    }
}
