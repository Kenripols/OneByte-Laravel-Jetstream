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

        $table->foreignId('qr_plate_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('user_id')
              ->nullable()
              ->constrained()
              ->nullOnDelete();

        $table->string('cell_phone')->nullable();

        $table->string('ip')->nullable();
        $table->text('user_agent')->nullable();

        $table->decimal('lat', 10, 7)->nullable();
        $table->decimal('lng', 10, 7)->nullable();

        $table->json('metadata')->nullable();

        $table->timestamps();

        $table->index('qr_plate_id');
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
