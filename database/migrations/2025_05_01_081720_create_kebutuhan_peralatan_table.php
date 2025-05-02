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
             // Ubah ke string karena foreign key-nya ke `id_proyek` yang bertipe string
             $table->string('rencana_proyek_id');
             $table->foreign('rencana_proyek_id')->references('id_proyek')->on('rencana_proyek')->onDelete('cascade');
            $table->integer('nomor')->nullable();
            $table->string('fase')->nullable();
            $table->string('peralatan')->nullable();
            $table->string('bahan')->nullable();
            $table->timestamps();
        });
        
    }
    
    public function down()
    {
        Schema::dropIfExists('kebutuhan_peralatan');
    }
    
};
