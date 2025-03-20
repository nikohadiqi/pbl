<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tahapan_pelaksanaan_proyek', function (Blueprint $table) {
            $table->id();
            $table->string('tahapan');
            $table->integer('pic');
            $table->integer('score');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tahapan_pelaksanaan_proyek');
    }
};
