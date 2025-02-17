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
        Schema::create('timpbl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_pbl')->constrained('periodepbl')->onDelete('cascade');
            $table->string('kelas');
            $table->string('code_tim');
            $table->foreignId('ketua_tim')->constrained('dosen')->onDelete('cascade');
            $table->json('anggota_tim'); // Menyimpan data anggota tim dalam format JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timpbl');
    }
};
