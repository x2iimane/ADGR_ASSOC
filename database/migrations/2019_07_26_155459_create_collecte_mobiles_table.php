<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollecteMobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collecte_mobiles', function (Blueprint $table) {
            $table->increments('id');
            $table->date("date");
            $table->string("libCollecte");
            $table->string("x");
            $table->string("y");
            $table->string("lieu");
            $table->integer("zone_id")->unsigned()->index();
            $table->foreign("zone_id")->references("id")->on("zones")->onDelete("cascade")->onUpdate("cascade");
            $table->integer("nombre_presents")->nullable()->default(null);
            $table->integer("nombre_contre_indiques")->nullable()->default(null);
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
        Schema::dropIfExists('collecte_mobiles');
    }
}
