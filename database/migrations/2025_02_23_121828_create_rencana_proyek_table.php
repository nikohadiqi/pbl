<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rencana_proyek', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel tim pbl dan mahasiswa
            $table->foreignId('timpbl_id')->constrained('timpbl')->onDelete('cascade');
            // Kolom berikut dibuat nullable
            $table->string('judul_proyek')->nullable();
            $table->string('pengusul_proyek')->nullable();
            $table->string('manajer_proyek')->nullable();
            $table->text('luaran')->nullable();
            $table->text('sponsor')->nullable();
            $table->decimal('biaya', 10, 2)->nullable();
            $table->string('klien')->nullable();
            $table->string('waktu')->nullable();
            $table->text('ruang_lingkup')->nullable();
            $table->text('rancangan_sistem')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rencana_proyek');
    }
};
