<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comiteEvenement extends Model
{
    public function comite(){
        return $this->belongsTo(Comite::class,"comite_id");
    }

    public function evenement(){
        return $this->belongsTo(Evenement::class, "evenement_id");
    }
}
