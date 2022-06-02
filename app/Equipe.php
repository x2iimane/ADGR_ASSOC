<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    public function benevoleEquipe(){
        return $this->hasMany("App\benevoleEquipe");
    }

    public function evenement(){
        return $this->hasOne("App\Evenement", "id", "Evenement_id");
    }

    public function responsable(){
        return $this->hasOne("App\Benevole","id","responsable_id");
    }
}
