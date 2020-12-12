<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compte');
            $table->unsignedBigInteger('modalitePaiement');
            $table->string('NumeroCompte')->nullable();
            $table->double('somme');
            $table->string('etat');
            $table->date('date');
            $table->unsignedBigInteger('transaction');
            $table->timestamps();
            $table->foreign('compte')->references('id')->on('comptes')->onDelete('cascade');
            $table->foreign("modalitePaiement")->references("id")->on("modalite_de_paiements")->onDelete("cascade");
            $table->foreign("transaction")->references("id")->on("transactions")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charges');
    }
}
