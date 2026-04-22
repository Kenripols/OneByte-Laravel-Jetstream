<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('qr_plate_events', function (Blueprint $table) {
        $table->id();
        $table->foreignId('qr_plate_id')->constrained()->cascadeOnDelete();
        $table->string('type'); 
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        /*
    generated   -> Fecha en que el QR fue generado (creación en sistema)
    downloaded  -> Fecha en que el QR fue descargado (habilitado para uso)
    claimed     -> fecha en que se leyo e hizo login por lo que nadie lo puede agarrar
    //registered  ->Fecha en que el usuario se registró usando este QR
    assigned    ->Fecha en que se asigno a una mascota
    expired     -> Fecha de caducidad del QR
    replaced    -> la mascota obtuvo otro QR
*/
        $table->json('metadata')->nullable(); // opcional
        $table->index('qr_plate_id');
        $table->index('type');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_plate_events');
    }
};
