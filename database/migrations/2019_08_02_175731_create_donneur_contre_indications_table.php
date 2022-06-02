<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonneurContreIndicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donneur_contre_indications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("donneur_id")->unsigned()->index();
            $table->integer("contre_indication_id")->unsigned()->index();
            $table->foreign("donneur_id")->references("id")->on("donneurs")->onDelete("cascade");
            $table->foreign("contre_indication_id")->references("id")->on("contre_indications")->onDelete("cascade");
            $table->date("dateDebut");
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
        Schema::dropIfExists('donneur_contre_indications');
    }
}
