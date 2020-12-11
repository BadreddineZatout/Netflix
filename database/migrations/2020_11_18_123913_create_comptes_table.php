<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComptesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comptes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('mobile');
            $table->string('email')->unique();
            $table->string('adresse');
            $table->string('password');
            $table->unsignedBigInteger('wilaya');
            $table->unsignedBigInteger('commune');
            $table->double('balanceCharge');
            $table->double('totalAchatAbonnement');
            $table->double('balanceActuel');
            $table->foreign("Wilaya")->references("id")->on("wilayas")->onDelete("cascade");
            $table->foreign("commune")->references("id")->on("communes")->onDelete("cascade");
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
        Schema::dropIfExists('comptes');
    }
}
