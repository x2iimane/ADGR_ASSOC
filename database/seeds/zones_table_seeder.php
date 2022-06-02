<?php

use Illuminate\Database\Seeder;
use App\Zone as Zone;
class zones_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 2 ; $i <= 12 ; $i++){
            for($j = 1; $j <= 10; $j++){
                Zone::create([
                    "libZone" => "Zone".$j,
                    "codePostal" => $i.$j,
                    "ville_id" => $i
                ]);
            }
        }
    }
}
