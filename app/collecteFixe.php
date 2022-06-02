<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class collecteFixe extends Model
{
    public function centre(){
        return $this->belongsTo("App\Centre");
    }

    public function collecte(){
        return $this->hasOne(collecte::class, "collecte_id" ,"id");
    }

}
