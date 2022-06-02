<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class collecteMobile extends Model
{
    public function zone(){
        return $this->belongsTo("App\Zone");
    }

    public function collecte(){
        return $this->hasOne(collecte::class, "collecte_id", "id");
    }
}
