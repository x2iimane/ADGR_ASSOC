<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class groupeSanguin extends Model
{
    public function donneur(){
        return $this->hasMany("App\Donneur");
    }
}
