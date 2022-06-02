<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonExternesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('don_externes', function (Blueprint $table) {
            $table->increments('id');
            $table->date("date");
            $table->string("raison");
            $table->integer("donneur_id")->unsigned()->index();
            $table->foreign("donneur_id")->references("id")->on("donneurs")->onDelete("cascade");
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
        Schema::dropIfExists('don_externes');
    }
}
