<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tim_proyek', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel tim PBL dan mahasiswa
            // $table->foreignId('timpbl_id')->constrained('timpbl')->onDelete('cascade');
            $table->foreignId('rencana_proyek_id')->constrained('rencana_proyek')->onDelete('cascade');

            $table->string('nama')->nullable();
            $table->string('nim')->nullable();
            $table->string('program_studi')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tim_proyek');
    }
};
