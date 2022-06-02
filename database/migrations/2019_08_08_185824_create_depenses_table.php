<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("compte_id")->unsigned()->index();
            $table->integer("Evenement_id")->unsigned()->index();
            $table->double("montant");
            $table->integer("categorie_depense_id")->unsigned()->index();
            $table->string("motif");
            $table->string("remarque")->nullable()->default(null);
            $table->foreign("compte_id")->references("id")->on("comptes")->onDelete("cascade");
            $table->foreign("Evenement_id")->references("id")->on("evenements")->onDelete("cascade");
            $table->foreign("categorie_depense_id")->references("id")->on("categorie_depenses")->onDelete("cascade");
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
        Schema::dropIfExists('depenses');
    }
}
