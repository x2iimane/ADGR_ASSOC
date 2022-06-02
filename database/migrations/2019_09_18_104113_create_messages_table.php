<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("donneur_id")->unsigned()->index();
            $table->foreign("donneur_id")->references("id")->on("donneurs")->onDelete("cascade");
            $table->string("objet");
            $table->text("contenu");
            $table->string("reponse")->nullable()->default(null);
            $table->timestamp("date_reponse")->nullable()->default(null);
            $table->integer("benevole_id")->unsigned()->index()->nullable()->default(null);
            $table->foreign("benevole_id")->references("id")->on("benevoles");
            $table->integer("status");
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
        Schema::dropIfExists('messages');
    }
}
