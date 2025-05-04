<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rencana_proyek', function (Blueprint $table) {
            $table->id(); // ID auto increment untuk identifikasi unik proyek
            $table->string('id_tim');
            $table->string('judul_proyek')->nullable();
            $table->string('pengusul_proyek')->nullable();
            $table->string('manajer_proyek')->nullable();
            $table->string('luaran')->nullable();
            $table->string('sponsor')->nullable();
            $table->decimal('biaya', 10, 2)->nullable();
            $table->string('klien')->nullable();
            $table->string('waktu')->nullable();
            $table->string('ruang_lingkup')->nullable();
            $table->string('rancangan_sistem')->nullable();
            $table->timestamps();
        
            // Foreign Key Constraint
            $table->foreign('id_tim')->references('id_tim')->on('timpbl')->onDelete('cascade');
        });
    } 
};
