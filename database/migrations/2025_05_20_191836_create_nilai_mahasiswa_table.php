<?php

// database/migrations/xxxx_xx_xx_create_nilai_mahasiswa_table.php

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
            $table->unsignedBigInteger('rubrik_id');
            $table->foreign('rubrik_id')->references('id')->on('rubrik_penilaian')->onDelete('cascade');
            $table->unsignedBigInteger('pengampu_id');
            $table->foreign('pengampu_id')->references('id')->on('pengampu')->onDelete('cascade');
            $table->unsignedTinyInteger('score'); // Nilai 1-4
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_mahasiswa');
    }
}
