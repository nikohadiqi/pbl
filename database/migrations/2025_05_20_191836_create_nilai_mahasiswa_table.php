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
            
            // Relasi ke mahasiswa
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('data_mahasiswa')->onDelete('cascade');

            // Relasi ke pengampu
            $table->unsignedBigInteger('pengampu_id');
            $table->foreign('pengampu_id')->references('id')->on('pengampu')->onDelete('cascade');

            // Aspek penilaian (lebih baik gunakan tipe numerik, misal integer)
            $table->integer('critical_thinking')->nullable();
            $table->integer('kolaborasi')->nullable();
            $table->integer('kreativitas')->nullable();
            $table->integer('komunikasi')->nullable();
            $table->integer('fleksibilitas')->nullable();
            $table->integer('kepemimpinan')->nullable();
            $table->integer('produktifitas')->nullable();
            $table->integer('social_skill')->nullable();
            $table->integer('konten')->nullable();
            $table->integer('tampilan_visual_presentasi')->nullable();
            $table->integer('kosakata')->nullable();
            $table->integer('tanya_jawab')->nullable();
            $table->integer('mata_gerak_tubuh')->nullable();
            $table->integer('penulisan_laporan')->nullable();
            $table->integer('pilihan_kata')->nullable();
            $table->integer('konten_2')->nullable();
            $table->integer('sikap_kerja')->nullable();
            $table->integer('proses')->nullable();
            $table->integer('kualitas')->nullable();

            // Nilai akhir
            $table->integer('total_nilai')->nullable();
            $table->float('angka_nilai')->nullable();
            $table->string('huruf_nilai')->nullable();
            $table->json('nilai_aspek_json')->nullable(); // JSON backup/komposit nilai

            // Dosen pengisi nilai
            $table->string('dosen_id')->nullable();

            $table->timestamps();

            // Optional: Tambahan unique key untuk mencegah duplicate nilai oleh dosen sama untuk matkul sama
            $table->unique(['nim', 'pengampu_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_mahasiswa');
    }
}
