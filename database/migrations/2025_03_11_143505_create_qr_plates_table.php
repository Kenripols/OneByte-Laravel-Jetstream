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
        Schema::create('qr_plates', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique; // Campo del código QR
            $table->unsignedBigInteger('pet_id')->nullable(); //puede ser null porque al generar un qr no está asignado a una mascota
            $table->date('iDate')->nullable(); // Fecha inicial es la fecha en la cual un qr es asignado a una mascota (puede ser null)
            $table->date('eDate')->nullable(); // Fecha Final es la fecha en la cual un qr vence, sería la fecha inicial + 2 años (puede ser null)
            $table->unsignedBigInteger('batch_id')->nullable()->index();// numero de lote en el que fue descargado
            $table->date('generated_at')->nullable();// fecha en que se descarga,
            $table->date('downloaded_at')->nullable();// fecha en que se descarga
            $table->date('asoc_at')->nullable();// fecha en que se le pone a un perro
            $table->date('finish_at')->nullable();// fecha de caducidad
            // Clave foránea a la tabla pets
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
        Schema::dropIfExists('qr_plates');
    }
};
