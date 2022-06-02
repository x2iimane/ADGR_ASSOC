<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenevoleComitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benevole_comites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("comite_id")->unsigned()->index();
            $table->foreign("comite_id")->references("id")->on("comites")->onDelete("cascade");
            $table->integer("benevole_id")->unsigned()->index();
            $table->foreign("benevole_id")->references("id")->on("benevoles")->onDelete("cascade");
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
        Schema::dropIfExists('benevole_comites');
    }
}
