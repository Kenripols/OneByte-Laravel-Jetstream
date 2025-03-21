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
        Schema::create('owners', function (Blueprint $table) {
            $table->timestamps();
            $table->string('docType');
            $table->string('docNum');
            $table->string('fName');
            $table->string('fName2')->nullable();
            $table->string('sName1');
            $table->string('sName2')->nullable();
            $table->primary('user_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
