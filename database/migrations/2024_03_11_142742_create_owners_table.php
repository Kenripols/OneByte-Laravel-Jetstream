<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('docType');
            $table->string('docNum');
            $table->unique(['docType', 'docNum']);
            $table->string('fName1');
            $table->string('fName2')->nullable();
            $table->string('sName1');
            $table->string('sName2')->nullable();
            
            
//          $table->foreignId('registration_qr_id')->nullable()->constrained('qr_plates')->nullOnDelete();
           
            $table->foreignId('registration_qr_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->index('user_id');
        });
    }

     //cancelar el migrate
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
