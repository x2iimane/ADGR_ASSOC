<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Centre extends Model
{
    public function zone(){
        return $this->belongsTo("App\Zone");
    }

    public function collecte(){
        return $this->hasMany("App\collecteFixe");
    }
}
