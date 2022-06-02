<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("Evenement_id")->unsigned()->index();;
            $table->foreign("Evenement_id")->references("id")->on("evenements")->onDelete("cascade");
            $table->integer("responsable_id")->unsigned()->index();
            $table->foreign("responsable_id")->references("id")->on("benevoles")->onDelete("cascade");
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
        Schema::dropIfExists('equipes');
    }
}
