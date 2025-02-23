<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kebutuhan_peralatan', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel tim PBL dan mahasiswa
            $table->foreignId('timpbl_id')->constrained('timpbl')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('rencana_proyek_id')->constrained('rencana_proyek')->onDelete('cascade');

            $table->string('proses')->nullable();
            $table->string('peralatan')->nullable();
            $table->string('bahan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kebutuhan_peralatan');
    }
};
