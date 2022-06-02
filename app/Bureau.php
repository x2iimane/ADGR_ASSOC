<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bureau extends Model
{
    public function bureauVille(){
        return $this->hasMany("App\BureauVille","bureau_id");
    }
    public function responsable(){
        return $this->hasOne("App\Benevole", "id", "responsable_id");
    }
}
