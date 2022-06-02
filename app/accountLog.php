<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class accountLog extends Model
{
    public function compte(){
        return $this->belongsTo("App\Compte", "compte_id");
    }
}
