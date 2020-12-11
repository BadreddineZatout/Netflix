<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('heure');
            $table->double('montant');
            $table->unsignedBigInteger('idCompteRecepteur');
            $table->unsignedBigInteger('idCompteEmeteur');
            $table->double('soldeAvant');
            $table->double('soldeApres');
            $table->string('piecejoint');
            $table->unsignedBigInteger('modalitePaiement');
            $table->string('etat');
            $table->timestamps();
            $table->foreign("idCompteRecepteur")->references("id")->on("comptes")->onDelete("cascade");
            $table->foreign("idCompteEmeteur")->references("id")->on("comptes")->onDelete("cascade");
            $table->foreign("modalitePaiement")->references("id")->on("modalite_de_paiements")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
