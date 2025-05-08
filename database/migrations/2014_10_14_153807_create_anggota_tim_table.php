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
        Schema::create('anggota_tim_pbl', function (Blueprint $table) {
            $table->string('kode_tim'); // foreign key
            $table->string('nama')->nullable();
            $table->string('nim')->unique();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('kode_tim')->references('kode_tim')->on('tim_pbl')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('anggota_tim_pbl');
    }
};
