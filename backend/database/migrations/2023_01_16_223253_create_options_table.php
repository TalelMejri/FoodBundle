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
    public $timestamps=false;
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string("nameOption");
            $table->double("prixOption");
            $table->foreignId('id_Food');
            $table->foreign('id_Food')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('id_category');
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('options');
    }
};
