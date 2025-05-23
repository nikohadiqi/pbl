<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggota_tim_pbl', function (Blueprint $table) {
            // Hapus unique constraint lama (nim saja)
            $table->dropUnique('anggota_tim_pbl_nim_unique'); // nama index default
            // Tambahkan unique gabungan
            $table->unique(['kode_tim', 'nim']);
        });
    }

    public function down(): void
    {
        Schema::table('anggota_tim_pbl', function (Blueprint $table) {
            $table->dropUnique(['kode_tim', 'nim']);
            $table->unique('nim');
        });
    }
};
