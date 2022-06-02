<?php

use Illuminate\Database\Seeder;
use App\Benevole as Benevole;
class benevoles_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Benevole::create(["nom" => "Hssine", "prenom" => "Mery", "CIN" => "EE835735", "tele"=>"063920099", "teleSec"=> "0612345678", "dateNaissance" => "1998-10-05", "email" => "anwarhssine@gmail.com", "profession" => "Etudiant", "sexe" => "H", "dateAdhesion" => "2019-05-10", "username" => "anwarhssine", "password" => bcrypt("123456789"), "adresse" => "Adresse", "etat_civil" => "1", "zone_id" => "1",  "role_id" => "1"]);
        Benevole::create(["nom" => "Lak", "prenom" => "Imane", "CIN" => "EE835734", "tele"=>"0639210098", "teleSec"=> "0612345677", "dateNaissance" => "1998-10-04", "email" => "ilaklaai@gmail.com", "profession" => "Etudiante", "sexe" => "F", "dateAdhesion" => "2019-05-09", "username" => "imaneraf", "password" => bcrypt("123456789"), "adresse" => "Adresse", "etat_civil" => "1", "zone_id" => "2", "role_id" => "1" ]);
        Benevole::create(["nom" => "nom", "prenom" => "prenom", "CIN" => "CIN", "tele"=>"0639212597", "teleSec"=> "0612345676", "dateNaissance" => "1998-10-03", "email" => "email@gmail.com", "profession" => "test", "sexe" => "F", "dateAdhesion" => "2019-05-08", "username" => "test", "password" => bcrypt("123456789"), "adresse" => "Adresse", "etat_civil" => "1", "zone_id" => "1","role_id" => "3" ]);
        Benevole::create(["nom" => "admin", "prenom" => "admin", "CIN" => "CINAdmin", "tele"=>"0639212586", "teleSec"=> "0612345656", "dateNaissance" => "1998-10-03", "email" => "email@email.com", "profession" => "prof", "sexe" => "H", "dateAdhesion" => "2019-05-08", "username" => "admin", "password" => bcrypt("123456789"), "adresse" => "Adresse", "etat_civil" => "1", "zone_id" => "5","role_id" => "2" ]);
    }
}
