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
        Schema::create('rubrik_penilaian', function (Blueprint $table) {
            $table->id();
            $table->string('aspek_penilaian');
            $table->enum('jenis', ['softskill', 'akademik']);
            $table->integer('bobot'); // dalam persen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rubrik_penilaian');
    }
};
