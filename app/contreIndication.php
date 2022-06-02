<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contreIndication extends Model
{
    public function donneurContreIndication(){
        $this->hasMany("App\donneurContreIndication");
    }

}
