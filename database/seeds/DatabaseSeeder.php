<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
        $this->call(villes_table_seeder::class);
        $this->call(zones_table_seeder::class);
        $this->call(categorie_depense_table_seeder::class);
        $this->call(Etats_Civils_table_seeder::class);
        $this->call(contre_indications_table_seeder::class);
        $this->call(roles_table_seeder::class);
        $this->call(benevoles_table_seeder::class);
        $this->call(bureaus_table_seeder::class);
        $this->call(groupe_sanguin_table_seeder::class);
        $this->call(donneurs_table_seeder::class);
        $this->call(type_events_seeder::class);
        $this->call(centres_table_seeder::class);

       
        //$this->call(UserTableSeeder::class);
       $this->call(centres_table_seeder::class);
    }
}
