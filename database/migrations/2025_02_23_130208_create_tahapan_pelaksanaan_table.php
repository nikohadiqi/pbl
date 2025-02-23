<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tahapan_pelaksanaan', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel tim PBL dan mahasiswa
            $table->foreignId('timpbl_id')->constrained('timpbl')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('rencana_proyek_id')->constrained('rencana_proyek')->onDelete('cascade');

            $table->integer('minggu')->nullable();
            $table->string('tahapan')->nullable();
            $table->string('pic')->nullable();
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tahapan_pelaksanaan');
    }
};
