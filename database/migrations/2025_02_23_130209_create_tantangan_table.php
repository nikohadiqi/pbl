<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tantangan', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel tim PBL dan mahasiswa
            $table->foreignId('timpbl_id')->constrained('timpbl')->onDelete('cascade');
            $table->foreignId('rencana_proyek_id')->constrained('rencana_proyek')->onDelete('cascade');

            $table->string('proses')->nullable();
            $table->string('tantangan')->nullable();
            $table->string('level')->nullable();
            $table->text('rencana_tindakan')->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tantangan');
    }
};
