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
        Schema::create('lign_commandes', function (Blueprint $table) {
            $table->id();
            $table->integer('Quantity');
            $table->double('prix_ligne_commande');
            $table->foreignId('commmandeId');
            $table->foreignId('ProductId');
            $table->foreign('ProductId')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('commmandeId')->references('id')->on('commandes')->cascadeOnDelete();
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
        Schema::dropIfExists('lign_commandes');
    }
};