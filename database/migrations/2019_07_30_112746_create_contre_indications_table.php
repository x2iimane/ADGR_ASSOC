<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContreIndicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contre_indications', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nom');
            $table->string("type");
            $table->integer('duree')->nullable()->default(null);
            $table->string('unite')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contre_indications');
    }
}
