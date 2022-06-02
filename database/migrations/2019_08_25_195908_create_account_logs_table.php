<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("compte_id")->unsigned()->index();
            $table->foreign("compte_id")->references("id")->on("comptes")->onDelete("cascade");
            $table->integer("solde");
            $table->date("date");
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
        Schema::dropIfExists('account_logs');
    }
}
