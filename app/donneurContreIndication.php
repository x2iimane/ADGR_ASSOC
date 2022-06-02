<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class donneurContreIndication extends Model
{
    public function contreIndication(){
        return $this->belongsTo("App\contreIndication");
    }
    public function donneur(){
        return $this->belongsTo("App\Donneur");
    }

    public function dateFin(){
        $ci = contreIndication::find( $this->contre_indication_id);
        if($ci){
            if($ci->type=='definitive')return "01-01-2000";
            $duree = $ci->duree;
            $unite = $ci->unite;
            if ($unite == "j") {
                $unite = "days";
            } elseif ($unite == "m") {
                $unite = "months";
            } else {
                $unite = "years";
            }
            $dateDebut = new \DateTime($this->dateDebut);
            $dateFin = $dateDebut->add(\DateInterval::createFromDateString($duree . " " . $unite));
            return $dateFin;
        }
        return "01-01-2000";
    }
}
