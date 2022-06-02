<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrees', function (Blueprint $table) {
            $table->increments('id');
            $table->string("source");
            $table->bigInteger("montant");
            $table->integer("compte_id")->unsigned()->index();;
            $table->foreign("compte_id")->references("id")->on("comptes")->onDelete("cascade");
            $table->string("remarque")->nullable()->default(null);;
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
        Schema::dropIfExists('entrees');
    }
}
