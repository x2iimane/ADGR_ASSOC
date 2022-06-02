<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    public function bureauVille(){
        return $this->hasMany("App\BureauVille", "ville_id");
    }

    public function zone(){
        return $this->hasMany("App\Zone")->orderBy("libZone");
    }
}
