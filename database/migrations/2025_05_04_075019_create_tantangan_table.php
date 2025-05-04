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
            $table->string('id_tim');
            $table->string('nomor')->nullable();
            $table->string('proses')->nullable();
            $table->string('isu')->nullable();
            $table->string('level_resiko')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
         
            // Foreign Key Constraint
            $table->foreign('id_tim')->references('id_tim')->on('timpbl')->onDelete('cascade');
        });
    }
};
