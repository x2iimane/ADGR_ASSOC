<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entree extends Model
{
    public function compte(){
        return $this->belongsTo("App\Compte", "compte_id");
    }
}
