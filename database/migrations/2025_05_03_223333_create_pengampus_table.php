<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengampu', function (Blueprint $table) {
            $table->id();
            $table->string('kelas_id');
            $table->string('dosen_id');
            $table->enum('status', ['Manajer Proyek', 'Dosen Mata Kuliah']);
            $table->string('matkul_id');
            $table->string('periode_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengampu');
    }
};
