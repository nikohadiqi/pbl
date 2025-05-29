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
        Schema::create('tahapan_pelaksanaan_proyeks', function (Blueprint $table) {
            $table->id();
            // Relasi dengan periode
            $table->foreignId('periode_id')->constrained('periodepbl')->onDelete('cascade');
            $table->string('tahapan');
            $table->integer('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahapan_pelaksanaan_proyeks');
    }
};
