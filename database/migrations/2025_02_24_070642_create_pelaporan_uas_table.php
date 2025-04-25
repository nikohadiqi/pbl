<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pelaporan_uas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timpbl_id')->constrained('timpbl')->onDelete('cascade');
            $table->text('keterangan')->nullable();
            $table->string('link_drive')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('laporan_pdf')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('pelaporan_uas');
    }
};
