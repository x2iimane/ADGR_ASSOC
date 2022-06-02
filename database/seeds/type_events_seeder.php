<?php

use Illuminate\Database\Seeder;
use App\TypeEvent as Type;
class type_events_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create(["libelle" => "collecte"]);
        Type::create(["libelle" => "rencontre"]);
    }
}
