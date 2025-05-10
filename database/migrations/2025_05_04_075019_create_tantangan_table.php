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
        Schema::create('tantangan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tim')->nullable();
            $table->string('nomor')->nullable();
            $table->string('proses')->nullable();
            $table->string('isu')->nullable();
            $table->string('level_resiko')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
         
            $table->foreign('kode_tim')->references('kode_tim')->on('tim_pbl')->onDelete('cascade');
        });
    }
};
