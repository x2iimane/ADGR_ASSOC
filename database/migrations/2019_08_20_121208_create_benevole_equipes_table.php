<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenevoleEquipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benevole_equipes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("benevole_id")->unsigned()->index();;
            $table->integer("equipe_id")->unsigned()->index();;
            $table->foreign("benevole_id")->references("id")->on("benevoles")->onDelete("cascade");
            $table->foreign("equipe_id")->references("id")->on("equipes")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benevole_equipes');
    }
}
