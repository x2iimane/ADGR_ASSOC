<?php

use Illuminate\Database\Seeder;

class UserTableSeederâ€‹ extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\User::class, 500)->create()->each(function($user){
$user->save();
});
    }
}
