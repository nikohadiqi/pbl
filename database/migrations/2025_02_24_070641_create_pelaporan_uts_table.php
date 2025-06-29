<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pelaporan_uts', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tim')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('hasil')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('laporan_pdf')->nullable();
            $table->timestamps();
            $table->foreign('kode_tim')->references('kode_tim')->on('tim_pbl')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelaporan_uts');
    }
};
