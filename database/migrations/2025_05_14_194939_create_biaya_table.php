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
        Schema::create('biaya', function (Blueprint $table) {
           $table->id();
            $table->string('kode_tim')->nullable();
            $table->string('fase')->nullable();
            $table->string('uraian_pekerjaan')->nullable();
            $table->string('perkiraan_biaya')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
         
            $table->foreign('kode_tim')->references('kode_tim')->on('tim_pbl')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biaya');
    }
};
