<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comite extends Model
{
    public function benevoleComite(){
        return $this->hasMany(benevoleComite::class, "comite_id");
    }

    public function comiteEvenement(){
        return $this->hasMany(comiteEvenement::class, "comite_id", "id");
    }

    public function responsable(){
        return $this->hasOne(Benevole::class, "id", "responsable_id");
    }
}
