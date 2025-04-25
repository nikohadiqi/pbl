<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('logbook', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timpbl_id')->constrained('timpbl')->onDelete('cascade');
            $table->text('aktivitas')->nullable();
            $table->text('hasil')->nullable();
            $table->string('foto_kegiatan')->nullable();
            $table->text('anggota1')->nullable();
            $table->text('anggota2')->nullable();
            $table->text('anggota3')->nullable();
            $table->text('anggota4')->nullable();
            $table->text('anggota5')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('logbook');
    }
};
