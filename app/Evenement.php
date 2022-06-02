<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    public function depenses(){
        return $this->hasMany("App\depense");
    }

    public function type(){
        return $this->belongsTo("App\TypeEvent");
    }

    public function equipe(){
        return $this->hasOne("App\Equipe","Evenement_id");
    }

    public function comiteEvenement(){
        return $this->hasOne("App\comiteEvenement", "Evenement_id");
    }

    public function appelTelephonique(){
        return $this->hasMany(appelTelephonique::class, "evenement_id");
    }
}
