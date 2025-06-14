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

            // Dosen penilai
            $table->string('dosen_id')->nullable();

            // Nilai aspek disimpan dalam JSON
            $table->json('nilai_aspek_json')->nullable();

            // Nilai akhir
            $table->integer('total_nilai')->nullable();
            $table->decimal('angka_nilai', 5, 2)->nullable();
            $table->string('huruf_nilai')->nullable();

            $table->timestamps();

            $table->unique(['nim', 'pengampu_id']); // nilai unik per mahasiswa per matkul
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_mahasiswa');
    }
}
