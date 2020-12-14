<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanneAbonnementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panne_abonnements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('abonnement');
            $table->date('date');
            $table->time('heure');
            $table->unsignedBigInteger('panne');
            $table->string('Etat'); //panne ou reglé
            $table->unsignedBigInteger('revendeur');
            $table->timestamps();
            $table->foreign("abonnement")->references("id")->on("abonnements")->onDelete("cascade");
            $table->foreign("panne")->references("id")->on("pannes")->onDelete("cascade");
            $table->foreign("revendeur")->references("id")->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panne_abonnements');
    }
}
