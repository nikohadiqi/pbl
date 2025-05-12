<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('logbook', function (Blueprint $table) {
            $table->id();
            $table->string('minggu')->nullable();
            $table->string('kode_tim')->nullable();
            $table->text('aktivitas')->nullable();
            $table->text('hasil')->nullable();
            $table->string('foto_kegiatan')->nullable();
            $table->text('anggota1')->nullable();
            $table->text('anggota2')->nullable();
            $table->text('anggota3')->nullable();
            $table->text('anggota4')->nullable();
            $table->text('anggota5')->nullable();
            $table->string('progress')->nullable();// Add this line for minggu
            $table->unsignedBigInteger('tahapan_id')->nullable(); // ✅ kolom relasi tahapan
            $table->timestamps();

            $table->foreign('kode_tim')->references('kode_tim')->on('tim_pbl')->onDelete('cascade');
            $table->foreign('tahapan_id')->references('id')->on('tpp_sem4')->onDelete('set null'); // ✅ foreign key ke tpp_sem4
        });

    }
    public function down()
    {
        Schema::dropIfExists('logbook');
    }
};
