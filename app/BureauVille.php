<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BureauVille extends Model
{
    public function ville(){
        return $this->belongsTo("App\Ville", "ville_id", "id");
    }

    public function bureau(){
        return $this->belongsTo("App\Bureau","bureau_id", "id");
    }
}
