<?php

// database/migrations/xxxx_xx_xx_create_rubrik_penilaian_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubrikPenilaianTable extends Migration
{
    public function up()
    {
        Schema::create('rubrik_penilaian', function (Blueprint $table) {
            $table->id();
            $table->string('metode_asesmen');
            $table->string('aspek_penilaian');
            $table->decimal('bobot', 5, 2); // Contoh: 0.20
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rubrik_penilaian');
    }
}
