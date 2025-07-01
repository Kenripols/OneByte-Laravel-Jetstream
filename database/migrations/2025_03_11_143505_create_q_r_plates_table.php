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
            $table->string('code'); // Campo del código QR
            $table->unsignedBigInteger('pet_id');

            $table->date('iDate')->nullable(); // Fecha inicial (puede ser null)
            $table->date('eDate')->nullable(); // Fecha final (puede ser null)

            // Llave foránea a la tabla pets
            $table->foreign('pet_id')
                  ->references('id')
                  ->on('pets')
                  ->onDelete('cascade');

            $table->timestamps();

            // Para soft deletes (borrado lógico)
            $table->softDeletes();
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
