<?php

use Illuminate\Database\Seeder;
use App\groupeSanguin as GroupeS;
class groupe_sanguin_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GroupeS::create([
            "libelle" => "A",
            "rhesus" => "-"
        ]);
        GroupeS::create([
            "libelle" => "B",
            "rhesus" => "-"
        ]);
        GroupeS::create([
            "libelle" => "AB",
            "rhesus" => "-"
        ]);
        GroupeS::create([
            "libelle" => "O",
            "rhesus" => "-"
        ]);
    }
}
