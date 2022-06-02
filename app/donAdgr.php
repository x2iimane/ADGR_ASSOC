<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class donAdgr extends Model
{
    public function donneur(){
        return $this->belongsTo("App\Donneur");
    }
    public function collecte(){
        $collecte = collecte::find($this->collecte_id);
        return $this->belongsTo(collecte::class,"collecte_id", "id");
    }
}
