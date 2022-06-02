<?php

namespace App;

//use http\Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DateTime;

class Donneur extends Authenticatable
{

    protected $guard = "donneur";

    protected $fillable = [
        "nom", "prenom", "email", "CIN", "numeroTelephone", "numeroTelephoneSecondaire", "dateNaissance", "adresse", "profession", "sexe", "etat", "dateDernierDon",
        "nombreEnfants", "moyenAdhesion", "type", "remarque", "etat_civil_id", "groupe_sanguin_id", "zone_id", "username",
    ];
    protected $hidden = [
        "password", "remember_token"
    ];



    public function carte()
    {
        return $this->hasOne("App\Carte");
    }

    public function zone()
    {
        return $this->belongsTo("App\Zone");
    }

    public function donsADGR()
    {
        return $this->hasMany("App\donAdgr");
    }

    public function donsExternes()
    {
        return $this->hasMany("App\donExterne");
    }

    public function donneurContreIndications()
    {
        return $this->hasMany("App\DonneurContreIndication");
    }

    public function etatCivil()
    {
        return $this->belongsTo("App\EtatCivil");
    }

    public function groupeSanguin()
    {
        return $this->belongsTo("App\groupeSanguin");
    }

    //Cause d'inaptitude
    public function getCauseInaptitude(){
        if($this->getProchainDon() == new DateTime("01-01-2000")){
            foreach($this->donneurContreIndications as $dci){
                if($dci->contreIndication->type == "definitive"){
                    echo $dci->contreIndication->nom."<br>";
                }
            }
        }else {
            if ($this->getAge() >= 63) {
                echo "Age";
            } else {
                $idContreI = 0;
                $dateFinCI = "";
                $prochain2 = new \DateTime(Date("01-01-2000"));
                $donneurContreIndications = $this->donneurContreIndications;
                foreach ($donneurContreIndications as $dci) {
                    if ($dci->contreIndication->type != "definitive") {
                        $dateFin = new \DateTime($dci->dateFin()->format("d-m-Y"));
                        if ($dateFin > $prochain2) {
                            $idContreI = $dci->contreIndication->id;
                            $dateFinCI = $dci->dateFin();
                            $prochain2 = $dateFin;
                        }
                    }
                }
                $dernierDon = $this->dateDernierDon != null ? new DateTime($this->dateDernierDon) : "";
                $dernierDonPlusTroisMois = $dernierDon != "" ? $dernierDon->add(\DateInterval::createFromDateString("3 months")) : "";
                if ($idContreI != 0) {
                    if ($dernierDon == "") {
                        $ci = \App\contreIndication::find($idContreI);
                        echo $ci->nom;
                    } else {
                        if ($dernierDonPlusTroisMois > $dateFinCI) {
                            echo "Dérnier don";
                        } else {
                            $ci = \App\contreIndication::find($idContreI);
                            echo $ci->nom;
                        }
                    }
                } else {
                    echo "Dérnier don";
                }
            }
        }
    }

    /* getProchainDon() retourne :
     *    Soit DateTime() avec la date du prochain don
     *    Soit DateTime() avec la date du 01-01-2000 si l'inaptitude est définitive donc pas de prochains dons
     *    Soit null si la date du prochain don est inférieure à la date d'aujourd'hui (donc le donneur est apte à donner le sang à la prochaine occasion)
     */
    public function getProchainDon()
    {
        $prochainDon = new DateTime("01-01-2000");
        if($this->getAge() >= 63){
            return new DateTime("01-01-2000");
        }else{
            $donneurContreIndication= $this->donneurContreIndications()->get();
            if(count($donneurContreIndication) > 0){
                //Présence de contre indications
                foreach($donneurContreIndication as $dci){
                    if($dci->contreIndication->type=="definitive")return new DateTime("01-01-2000");
                    if($dci->dateFin() > $prochainDon){
                        $prochainDon = $dci->dateFin();
                    }
                }
            }
            if($this->dateDernierDon != null){
                //Présence de dernier dons
                $dernierDonPlusTroisMois = new DateTime($this->dateDernierDon);
                $dernierDonPlusTroisMois->add(\DateInterval::createFromDateString("3 months"));
                if( $dernierDonPlusTroisMois > $prochainDon){
                    if($dernierDonPlusTroisMois > new DateTime(date("d-m-Y"))){
                        return $dernierDonPlusTroisMois;
                    }else{
                        if($prochainDon > new DateTime(date("d-m-Y"))){
                            return $prochainDon;
                        }else{
                            return null;
                        }
                    }
                }

            }else{
                //Absence de dernier dons
                if($prochainDon > new DateTime(date("d-m-Y"))){
                    return $prochainDon;
                }else{
                    return null;
                }
            }
        }
    }
    public function getAge(){
        $dateN = new \DateTime($this->dateNaissance);
        $diff = $dateN->diff(new DateTime(date("d-m-Y")));
        return $diff->y;
    }
    public function isApte(){
        $currentDate = new \DateTime(date("d-m-Y"));
        if($this->getAge() >= 63 || $this->getAge() < 18)return false;
        if($this->getProchainDon() == new \DateTime("01-01-2000")) return false;
        if ($this->getProchainDon() > $currentDate) {
            return false;
        }
        return true;
    }
}