<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categorieDepense extends Model
{
    public function depense(){
        return $this->hasMany("App\depense");
    }
}
