<?php

use Illuminate\Database\Seeder;
use App\Donneur as Donneur;
class donneurs_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1 ; $i < 10 ; $i++){
            Donneur::create([
                "nom" => "NomDonneur".$i,
                "prenom" => "PrenomDonneur".$i,
                "CIN" => "EE12345".$i,
                "numeroTelephone" => "06392125".$i,
                "numeroTelephoneSecondaire" => "06392125".$i,
                "dateNaissance" => "1998-10-0".$i,
                "adresse" => "Adresse".$i,
                "x" => "0",
                "y" => "0",
                "email" => "donneur".$i."@gmail.com",
                "profession" => "Etudiant",
                "sexe" => ($i%2 == 0)?"Homme":"Femme",
                "etat" => "1",
                "dateDernierDon" => null,
                "nombreEnfants" => "0",
                "moyenAdhesion" => "Rencontre ADGR",
                "type" => "0",
                "remarque" => null,
                "etat_civil_id" => "1",
                "groupe_sanguin_id" => "1",
                "zone_id" => "2",
                "username" => "donneur".$i,
                "password" => bcrypt("123456789"),
            ]);
        }
    }
}
