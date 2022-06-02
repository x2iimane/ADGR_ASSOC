<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class benevoleComite extends Model
{
    public function benevole(){
        return $this->hasOne(Benevole::class, "id", "benevole_id");
    }

    public function comite(){
        return $this->hasOne(Comite::class,"id","comite_id");
    }
}
