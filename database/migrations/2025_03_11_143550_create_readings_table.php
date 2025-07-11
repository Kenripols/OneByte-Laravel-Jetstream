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
        Schema::create('readings', function (Blueprint $table) {
            $table->id();
            $table->string('cellPhone');
            $table->dateTime('dateTime');
            $table->unsignedBigInteger('pet_id')->nullable();
            $table->unsignedBigInteger('QRPlate_id');
            $table->timestamps();
            $table->foreign('QRPlate_id')->references('id')->on('q_r_plates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readings');
    }
};
