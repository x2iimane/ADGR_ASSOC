<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class depense extends Model
{
    public function compte(){
        return $this->belongsTo("App\Compte","compte_id");
    }

    public function evenement(){
        return $this->belongsTo("App\Evenement","Evenement_id");
    }

    public function categorie(){
        return $this->belongsTo("App\categorieDepense", "categorie_depense_id");
    }
}
