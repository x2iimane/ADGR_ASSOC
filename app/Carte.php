<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carte extends Model
{
    public function donneur(){
        return $this->belongsTo("\App\Donneur");
    }
}
