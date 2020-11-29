<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonnementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produit');
            $table->date('dateDebut');
            $table->date('datefin');
            $table->string('email');
            $table->string('password');
            $table->double('tarifVente');
            $table->double('tarifAchatEuro');
            $table->double('tarifAchatDinar');
            $table->string('typeCompte');
            $table->double('marge');
            $table->string('resultatcreation');
            $table->string('etat'); //panne ou reglé
            $table->timestamps();
            $table->foreign("produit")->references("id")->on("produits")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abonnements');
    }
}
