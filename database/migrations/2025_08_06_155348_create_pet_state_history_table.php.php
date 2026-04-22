<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
       Schema::create('pet_state_history', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pet_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('state');

        $table->timestamp('started_at');
        $table->timestamp('ended_at')->nullable();

        $table->timestamps();

        $table->index(['pet_id', 'ended_at']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_state_history');
    }
};
