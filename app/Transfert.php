<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfert extends Model
{
    public function source(){
        return $this->hasOne("App\Compte", "id", "compte1_id");
    }

    public function destination(){
        return $this->hasOne("App\Compte", "id", "compte2_id");
    }
}
