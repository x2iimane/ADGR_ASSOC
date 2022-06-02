<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonneursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donneurs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('CIN')->unique();
            $table->string('numeroTelephone');
            $table->string('numeroTelephoneSecondaire')->nullable()->default(null);
            $table->date('dateNaissance');
            $table->string('adresse');
            $table->string('x')->default('0');;
            $table->string('y')->default('0');
            $table->string('email')->unique();
            $table->string('profession');
            $table->string('sexe');
            $table->boolean('etat');
            $table->date('dateDernierDon')->nullable()->default(null);
            $table->integer('nombreEnfants')->nullable()->default(null);
            $table->string("moyenAdhesion");
            $table->boolean('type');
            $table->mediumText('remarque')->nullable()->default(null);;
            $table->integer('etat_civil_id')->unsigned()->index();
            $table->foreign('etat_civil_id')->references("id")->on("etat_civils");
            $table->integer('groupe_sanguin_id')->unsigned()->index();
            $table->foreign("groupe_sanguin_id")->references("id")->on("groupe_sanguins");
            $table->integer('zone_id')->unsigned()->index();
            $table->foreign('zone_id')->references("id")->on("zones");
            $table->string("username")->unique();
            $table->string("password");
            $table->rememberToken();
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
        Schema::dropIfExists('donneurs');
    }
}
