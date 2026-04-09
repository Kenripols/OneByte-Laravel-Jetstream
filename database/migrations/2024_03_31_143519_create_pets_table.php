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
            $table->string('photo')->nullable();
            $table->string('name');
            $table->date('bDate')->nullable();
            
            // Clave foránea a la tabla breeds
            $table->foreignId('breed_id')->nullable()->constrained()->cascadeOnDelete();

            // Clave foránea a la tabla owners (relacionada por user_id)
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');

            $table->timestamps();

            //Borrado lógico (opcional)
            $table->softDeletes();
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