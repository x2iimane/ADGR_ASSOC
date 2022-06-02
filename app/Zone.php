<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    public function ville(){
        return $this->belongsTo("App\Ville");
    }
    public function centre(){
        return $this->hasMany("App\Centre");
    }
    public function collecteMobile(){
        return $this->hasMany("App\collecteMobile");
    }
    public function donneurs(){
        return $this->hasMany("App\Zone");
    }
}
