<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('photo');
            $table->string('name');
            $table->date('bDate');
            //Clave foranea de Breed (Raza)
            $table->unsignedBigInteger('breed_id');
            $table->foreign('breed_id')->references('id')->on('breeds');
            //Clave foranea de Owner (Dueño)
            //$table->unsignedBigInteger('owner_id');
            $table->foreignid('owner_id')->references('user_id')->on('owners');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
