<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBureausTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bureaus', function (Blueprint $table) {
            $table->increments('id');
            $table->date("dateCreation");
            $table->integer("responsable_id")->unsigned()->index();
            $table->foreign("responsable_id")->references("id")->on("benevoles")->onDelete("cascade");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bureaus');
    }
}
