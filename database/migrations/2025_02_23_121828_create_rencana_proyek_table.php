<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rencana_proyek', function (Blueprint $table) {
            $table->string('id_proyek')->nullable();
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
            $table->integer('minggu')->nullable();
            $table->string('tahapan')->nullable();
            $table->string('pic')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('proses')->nullable();
            $table->string('peralatan')->nullable();
            $table->string('bahan')->nullable();
            $table->string('proses')->nullable();
            $table->string('tantangan')->nullable();
            $table->string('level')->nullable();
            $table->text('rencana_tindakan')->nullable();
            $table->text('catatan')->nullable();
            $table->string('proses')->nullable();
            $table->text('uraian_pekerjaan')->nullable();
            $table->decimal('perkiraan_biaya', 10, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->string('proses')->nullable();
            $table->text('uraian_pekerjaan')->nullable();
            $table->string('estimasi')->nullable();
            $table->text('catatan')->nullable();
            $table->string('nama')->nullable();
            $table->string('nim')->nullable();
            $table->string('program_studi')->nullable();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('rencana_proyek');
    }
};
