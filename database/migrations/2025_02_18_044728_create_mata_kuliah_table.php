<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('matakuliah', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('matakuliah');
            $table->text('sks')->nullable();
            $table->string('program_studi');
            // Relasi dengan periode
            $table->foreignId('periode_id')->constrained('periodepbl')->onDelete('cascade');
            $table->text('id_feeder')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matakuliah');
    }
};
