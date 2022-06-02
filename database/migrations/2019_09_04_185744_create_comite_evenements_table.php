<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComiteEvenementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comite_evenements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("comite_id")->unsigned()->index();
            $table->integer("evenement_id")->unsigned()->index();
            $table->foreign("comite_id")->references("id")->on("comites")->onDelete("cascade");
            $table->foreign("evenement_id")->references("id")->on("evenements")->onDelete("cascade");
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
        Schema::dropIfExists('comite_evenements');
    }
}
