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
        Schema::create('q_r_plates', function (Blueprint $table) {
            $table->id();
            $table->date('iDate');
            $table->date('eDate');
            $table->timestamps();
            $table->unsignedBigInteger('pet_id');
            $table->foreign('pet_id')->references('id')->on('pets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_r_plates');
    }
};
