<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rencana_proyek', function (Blueprint $table) {
            $table->id(); // ID auto increment untuk identifikasi unik proyek
            $table->string('kode_tim')->nullable();
            $table->string('judul_proyek')->nullable();
            $table->string('pengusul_proyek')->nullable();
            $table->string('manajer_proyek')->nullable();
            $table->string('luaran')->nullable();
            $table->string('sponsor')->nullable();
            $table->string('biaya')->nullable();
            $table->string('klien')->nullable();
            $table->string('waktu')->nullable();
            $table->string('ruang_lingkup')->nullable();
            $table->string('rancangan_sistem')->nullable();
            $table->string('evaluasi')->nullable();
            $table->timestamps();
            $table->foreign('kode_tim')->references('kode_tim')->on('tim_pbl')->onDelete('cascade');
        });
    } 
};
