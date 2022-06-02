<?php

use Illuminate\Database\Seeder;
use App\Centre as Centre;
class centres_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1 ; $i <= 20; $i++){
            Centre::create([
                "adresse" => "Adresse Centre".$i,
                "x" => "0",
                "y" => "0",
                "libCentre" => "CRTS".$i,
                "zone_id" => $i,
            ]);
        }
    }
}
