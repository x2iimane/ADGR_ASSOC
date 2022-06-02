<?php

use Illuminate\Database\Seeder;
use App\Ville as Ville;
class villes_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i = 1; $i<=10; $i++){
            Ville::create([
                "libVille" => "Ville".$i,
            ]);
        }

    }
}
