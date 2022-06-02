<?php

use Illuminate\Database\Seeder;
use App\contreIndication as ContreI;
class contre_indications_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContreI::create([
            "nom" => "ContreIndication P",
            "type" => "provisoire",
            "duree" => "10",
            "unite" => "j"
        ]);

        ContreI::create([
            "nom" => "ContreIndication P 2",
            "type" => "provisoire",
            "duree" => "3",
            "unite" => "m"
        ]);

        ContreI::create([
            "nom" => "ContreIndication D",
            "type" => "definitive",
            "unite" => "j"
        ]);

    }
}
