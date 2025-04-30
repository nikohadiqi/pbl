<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rencana_proyek', function (Blueprint $table) {
            $table->string('id_proyek')->primary();
            $table->string('judul_proyek')->nullable();
            $table->string('pengusul_proyek')->nullable();
            $table->string('manajer_proyek')->nullable();
            $table->string('luaran')->nullable();
            $table->string('sponsor')->nullable();
            $table->decimal('biaya', 10, 2)->nullable();
            $table->string('klien')->nullable();
            $table->string('waktu')->nullable();
            $table->string('ruang_lingkup')->nullable();
            $table->string('rancangan_sistem')->nullable();
            $table->string('tahapan_pelaksanaan')->nullable();
            $table->string('kebutuhan_peralatan')->nullable();
            $table->string('tantangan')->nullable();
            $table->string('estimasi')->nullable();
            $table->string('biaya_proyek')->nullable();
            $table->string('tim_proyek')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rencana_proyek');
    }
};
