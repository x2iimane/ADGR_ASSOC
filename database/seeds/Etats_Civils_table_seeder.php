<?php

use Illuminate\Database\Seeder;

use App\EtatCivil as EtatC;

class Etats_Civils_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EtatC::create(["libelle" => "Celibataire"]);
        EtatC::create(["libelle" => "Marie.e"]);
        EtatC::create(["libelle" => "Divorce.e"]);
        EtatC::create(["libelle" => "Veuf.ve"]);
    }
}
