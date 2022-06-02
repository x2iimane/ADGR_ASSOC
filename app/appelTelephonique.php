<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class appelTelephonique extends Model
{
    public function Benevole(){
        return $this->belongsTo("App\Benevole", "benevole_id", "id");
    }
    public function donneur(){
        return $this->hasOne("App\Donneur", "id", "donneur_id");
    }
    public function evenement(){
        return $this->belongsTo("App\Evenement", "evenement_id");
    }
}
