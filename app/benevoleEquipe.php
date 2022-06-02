<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class benevoleEquipe extends Model
{
    public function benevole(){
        return $this->belongsTo("App\Benevole");
    }

    public function equipe(){
        return $this->belongsTo("App\Equipe");
    }

}
