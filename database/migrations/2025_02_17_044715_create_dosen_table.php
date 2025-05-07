<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->string('nip')->primary();
            $table->string('nama');
            $table->string('no_telp');
            $table->string('email');
            $table->string('prodi');
            $table->string('jurusan');
            $table->string('jenis_kelamin')->nullable();
            $table->string('status_dosen')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
