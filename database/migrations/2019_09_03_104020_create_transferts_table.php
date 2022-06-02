<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("compte1_id")->unsigned()->index();
            $table->integer("compte2_id")->unsigned()->index;
            $table->float("montant");
            $table->foreign("compte1_id")->references("id")->on("comptes")->onDelete("cascade");
            $table->foreign("compte2_id")->references("id")->on("comptes")->onDelete("cascade");
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
        Schema::dropIfExists('transferts');
    }
}
