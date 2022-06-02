<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class donExterne extends Model
{
    public function donneur(){
        return $this->belongsTo("App\Donneur");
    }
}
