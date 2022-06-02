<?php

use Illuminate\Database\Seeder;
use App\categorieDepense as Categorie;
class categorie_depense_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categorie::create(["libelle" => "cat1"]);
        Categorie::create(["libelle" => "cat2"]);
        Categorie::create(["libelle" => "cat3"]);
    }
}
