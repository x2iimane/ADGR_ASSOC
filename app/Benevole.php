<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable as Notifiable;
class Benevole extends Authenticatable
{

    use Notifiable;

    protected $guard = "benevole";


    protected $fillable = [
        "nom", "prenom", "CIN", "tele", "teleSec", "dateNaissance", "dateAdhesion", "email", "password", "login", "profession", "sexe", "etat", "droitAcces", "etat_civil", "x", "y", "adresse"
    ];


    protected $hidden = [
        "password", "remember_token"
    ];




    public function benevoleEquipe(){
        return $this->hasMany("App\benevoleEquipe");
    }

    public function benevoleComite(){
        return $this->hasMany("App\benevoleComite", "benevole_id","id");
    }

    public function etatCivil(){
        return $this->hasOne("App\EtatCivil","id","etat_civil");
    }

    public function role(){
        return $this->hasOne("App\Role", "id", "role_id");
    }

    public function zone(){
        return $this->hasOne("App\Zone", "id", "zone_id");
    }
}
