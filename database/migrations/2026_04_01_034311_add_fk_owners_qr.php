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
      Schema::table('owners', function (Blueprint $table) {
    $table->foreign('registration_qr_id')
          ->references('id')
          ->on('qr_plates')
          ->nullOnDelete();
});  //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
