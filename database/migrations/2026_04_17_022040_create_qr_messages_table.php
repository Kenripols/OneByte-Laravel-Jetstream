<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('qr_plate_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Lectura 
            $table->foreignId('reading_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // Usuario 
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // Contenido
            $table->text('message');

            // Foto opcional
            $table->string('photo_path')->nullable();

            // Estado para el dueño
            $table->boolean('seen')->default(false);

            $table->timestamps();

            $table->index('qr_plate_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_messages');
    }
};