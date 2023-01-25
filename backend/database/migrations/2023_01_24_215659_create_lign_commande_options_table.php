<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lign_commande_options', function (Blueprint $table) {
            $table->id();
            $table->string("nameOption");
            $table->foreignId('IdLignCommande');
            $table->foreign('IdLignCommande')->references('id')->on('lign_commandes')->cascadeOnDelete();
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
        Schema::dropIfExists('lign_commande_options');
    }
};
