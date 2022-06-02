<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtatCivil extends Model
{
    public function donneur(){
        return $this->hasMany('App\Donneur');
    }
}
