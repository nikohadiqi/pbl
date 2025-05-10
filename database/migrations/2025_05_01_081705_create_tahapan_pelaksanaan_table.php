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
        Schema::create('tahapan_pelaksanaan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tim')->nullable();
            $table->string('minggu')->nullable();
            $table->string('tahapan')->nullable();
            $table->string('pic')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->foreign('kode_tim')->references('kode_tim')->on('tim_pbl')->onDelete('cascade');
        });
    }
};
