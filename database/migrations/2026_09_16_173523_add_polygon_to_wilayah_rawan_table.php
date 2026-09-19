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
    Schema::table('wilayah_rawan', function (Blueprint $table) {
        $table->json('polygon')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('wilayah_rawan', function (Blueprint $table) {
        $table->dropColumn('polygon');
    });
}
};