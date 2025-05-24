<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pelaporan_uts', function (Blueprint $table) {
            $table->string('updated_by')->nullable()->after('laporan_pdf');
        });

        Schema::table('pelaporan_uas', function (Blueprint $table) {
            $table->string('updated_by')->nullable()->after('laporan_pdf');
        });
    }

    public function down()
    {
        Schema::table('pelaporan_uts', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });

        Schema::table('pelaporan_uas', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });
    }
};
