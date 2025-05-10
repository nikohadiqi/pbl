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
        Schema::create('kebutuhan_peralatan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tim')->nullable();
            $table->integer('nomor')->nullable();
            $table->string('fase')->nullable();
            $table->string('peralatan')->nullable();
            $table->string('bahan')->nullable();
            $table->timestamps();
          
            $table->foreign('kode_tim')->references('kode_tim')->on('tim_pbl')->onDelete('cascade');
        });
    }
    
};
