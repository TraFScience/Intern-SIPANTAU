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
        Schema::create('kejadian_bencana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('verified_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('jenis_bencana_id')->constrained('jenis_bencana')->onDelete('cascade');
            $table->foreignId('wilayah_id')->constrained('wilayah')->onDelete('cascade');
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->dateTime('tanggal_kejadian');
            $table->string('gambar', 255)->nullable();
            $table->enum('status_verifikasi', ['menunggu', 'terverifikasi', 'ditolak'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kejadian_bencana');
    }
};
