<?php

use Illuminate\Database\Seeder;
use App\Bureau as Bureau;
class bureaus_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bureau::create(["dateCreation" => "2019-05-20", "responsable_id" => "1"]);
        Bureau::create(["dateCreation" => "2019-06-15", "responsable_id" => "2"]);
    }
}
