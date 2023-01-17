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
        Schema::create('option_specifiques', function (Blueprint $table) {
            $table->id();
            $table->string("nameOptionSpecifique");
            $table->double("prixOptionSpecifique");
            $table->foreignId('Id_Product');
            $table->foreign('Id_Product')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('option_specifiques');
    }
};
