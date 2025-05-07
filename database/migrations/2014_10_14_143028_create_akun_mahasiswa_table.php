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
            Schema::create('akun_mahasiswa', function (Blueprint $table) {
                $table->id();
                $table->string('kode_tim')->nullable(); // Foreign key, bukan primary
                $table->string('role')->default('mahasiswa');
                $table->string('nim')->unique();
                $table->string('password');
                $table->timestamps();
    
                // Foreign key dari mahasiswa.kode_tim
                $table->foreign('kode_tim')->references('kode_tim')->on('tim_pbl')->onDelete('cascade');
            });
        }
    
        public function down(): void {
            Schema::dropIfExists('akun_mahasiswa');
        }
};
