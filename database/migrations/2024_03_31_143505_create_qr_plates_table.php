<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_plates', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();//Código único del QR (lo que se imprime/escanea)
            //Estado del QR:
            //1 = generado
            //2 = descargado
            //3 = reservado
            //4 = usado para registro
            //4 = asociado a mascota
            //5 = caducado
            //6 = sustituido
            $table->unsignedTinyInteger('status')->default(1);
            //Se quitó Pet_id porque no aporta información relevante, el QR se asocia a la mascota a través de la tabla de historial de asignación que realiza la función de control además.
            $table->unsignedBigInteger('pet_id')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable()->index(); //numero de lote en que se descargo
            
            $table->timestamps();
            $table->softDeletes();
            $table->index('status');
            
        });
    }

    public function down(): void{
        Schema::dropIfExists('qr_plates');
    }
};