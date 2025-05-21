<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiMahasiswaTable extends Migration
{
    public function up()
    {
        Schema::create('nilai_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('data_mahasiswa')->onDelete('cascade');
            // Semua aspek penilaian disimpan sebagai string
            $table->string('critical_thinking')->nullable();
            $table->string('kolaborasi')->nullable();
            $table->string('kreativitas')->nullable();
            $table->string('komunikasi')->nullable();
            $table->string('fleksibilitas')->nullable();
            $table->string('kepemimpinan')->nullable();
            $table->string('produktifitas')->nullable();
            $table->string('social_skill')->nullable();
            $table->string('konten')->nullable();
            $table->string('tampilan_visual_presentasi')->nullable();
            $table->string('kosakata')->nullable();
            $table->string('tanya_jawab')->nullable();
            $table->string('mata_gerak_tubuh')->nullable();
            $table->string('penulisan_laporan')->nullable();
            $table->string('pilihan_kata')->nullable();
            $table->string('konten_2')->nullable();
            $table->string('sikap_kerja')->nullable();
            $table->string('proses')->nullable();
            $table->string('kualitas')->nullable();
            $table->integer('total_nilai')->nullable();        // tambahkan
            $table->float('angka_nilai')->nullable();          // tambahkan
            $table->string('huruf_nilai')->nullable();         // tambahkan
            $table->json('nilai_aspek_json')->nullable();      // tambahkan
            $table->string('dosen_id')->nullable();            // tambahkan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_mahasiswa');
    }
}
