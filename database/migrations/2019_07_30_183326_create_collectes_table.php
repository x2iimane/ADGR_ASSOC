<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collectes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("collecte_id");
            $table->integer("typeCollecte");
            $table->integer("Evenement_id")->unsigned()->index();
            $table->foreign("Evenement_id")->references("id")->on("evenements")->onDelete("cascade");
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
        Schema::dropIfExists('collectes');
    }
}
