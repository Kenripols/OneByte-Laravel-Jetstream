<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 /* public function up()
    {
    Schema::table('q_r_plates', function (Blueprint $table) {
        $table->date('iDate')->nullable()->after('pet_id');
        $table->date('eDate')->nullable()->after('iDate');
    });
    }

public function down()
    {
    Schema::table('q_r_plates', function (Blueprint $table) {
        $table->dropColumn(['iDate', 'eDate']);
    });
}
*/
};
