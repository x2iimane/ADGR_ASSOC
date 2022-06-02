<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollecteFixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collecte_fixes', function (Blueprint $table) {
            $table->increments('id');
            $table->date("date");
            $table->string("libCollecte");
            $table->integer("centre_id")->unsigned()->index();
            $table->foreign("centre_id")->references("id")->on("centres")->onDelete("cascade")->onUpdate("cascade");
            $table->integer("nombre_presents")->nullable()->default(null);
            $table->integer("nombre_contre_indiques")->nullable()->default(null);
            $table->integer("nombre_dons")->nullable()->default(null);
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
        Schema::dropIfExists('collecte_fixes');
    }
}
