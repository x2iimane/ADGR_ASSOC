<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class collecte extends Model
{
    public function collecte(){
        if($this->typeCollecte == 1 ){
            return $this->hasOne(collecteFixe::class, "id", "collecte_id");
        }
        return $this->hasOne(collecteMobile::class, "id", "collecte_id");
    }

    public function dons(){
        return $this->hasMany(donAdgr::class, "collecte_id", "id");
    }

    public function evenement(){
        return $this->belongsTo(Evenement::class, "Evenement_id", "id");
    }
}
