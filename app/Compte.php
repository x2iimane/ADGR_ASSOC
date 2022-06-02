<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    public function depenses(){
        return $this->hasMany("App\depense");
    }

    public function entrees(){
        return $this->hasMany("App\Entree");
    }

    public function transfertsEntrants(){
        return $this->hasMany(Transfert::class,"compte2_id");
    }

    public function transfertsSortants(){
        return $this->hasMany(Transfert::class,"compte1_id");
    }



    public function logs(){
        return $this->hasMany("App\accountLog","compte_id");
    }
    public function newLog(){
        $log = new accountLog();
        $log->compte_id = $this->id;
        $log->solde = $this->solde;
        $log->date = date("Y-m-d");
        $log->save();
    }

    public function retrait($montant = 0){
        if($montant > 0){
            $this->solde -= $montant;
            $this->newLog();
        }
    }

    public function depos($montant){
        if($montant > 0){
            $this->solde += $montant;
            $this->newLog();
        }
    }
}
