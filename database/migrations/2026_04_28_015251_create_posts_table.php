<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
//en el dashboard se muestran "novedades" es solo una foto con un texto, como ser tips de uso, novedades que escribe el admin "ya somo 3000" o algo asi, 
// y tambien cuando una mascota se pierde podes marcar "publicar" y se crea un post con la foto de la mascota, el nombre, la raza y el barrio, es un texto de 80 caracteres y una foto 
public function up(): void
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();

        // Contenido
        $table->string('title', 80); //mensaje

        // Tipo: tip | news
        $table->enum('type', ['tip', 'news','lost']);

        // Relación  con mascota (si corresponde)
        $table->foreignId('pet_id')->nullable()->constrained()->nullOnDelete();

        // Ubicación, barrio (lo elige el usuario)
        //$table->string('zone')->nullable();
        
        // Imagen path o URL, si es de la mascota levanta la foto de perfil de la mascota
        $table->string('image')->nullable();

        // publicada o no
        $table->boolean('is_active')->default(true);

        // Publicación programada el admin pude escribir y publicar un dia, estilo programar saludo de finde año
        $table->timestamp('publish_at')->nullable();
        $table->timestamp('expires_at')->nullable();

        $table->timestamps();

        $table->softDeletes();

    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
