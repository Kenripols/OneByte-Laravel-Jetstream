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
    $table->string('code')->unique();
    $table->unsignedBigInteger('pet_id')->nullable(); //lo hice nullable para generar los qr en solitario
    $table->date('iDate')->nullable(); // no se que hacen estas 2 fechas
    $table->date('eDate')->nullable();//
    $table->unsignedBigInteger('batch_id')->nullable()->index();// numero de lote en el que fue descargado
    $table->date('generated_at')->nullable();// fecha en que se descarga,
    $table->date('downloaded_at')->nullable();// fecha en que se descarga
    $table->date('asoc_at')->nullable();// fecha en que se le pone a un perro
    $table->date('finish_at')->nullable();// fecha de caducidad

    $table->foreign('pet_id')
        ->references('id')
        ->on('pets')
        ->onDelete('cascade');

    $table->timestamps();
    $table->softDeletes();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_plates');
    }
};
