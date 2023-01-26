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
        Schema::create('ligne_commande_options', function (Blueprint $table) {
            $table->id();
            $table->string("nameOption");
            $table->foreignId('lign_commande_id');
            $table->foreign('lign_commande_id')->references('id')->on('lign_commandes')->cascadeOnDelete();
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
