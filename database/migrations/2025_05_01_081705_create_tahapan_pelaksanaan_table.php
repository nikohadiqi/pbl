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
        
            // Ubah ke string karena foreign key-nya ke `id_proyek` yang bertipe string
            $table->string('rencana_proyek_id');
            $table->foreign('rencana_proyek_id')->references('id_proyek')->on('rencana_proyek')->onDelete('cascade');
        
            $table->string('minggu')->nullable();
            $table->string('tahapan')->nullable();
            $table->string('pic')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
        
    }
    
    public function down()
    {
        Schema::dropIfExists('tahapan_pelaksanaan');
    }
};
