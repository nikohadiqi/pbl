<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('logbook', function (Blueprint $table) {
            $table->string('updated_by')->nullable()->after('progress');
        });
    }

    public function down()
    {
        Schema::table('logbook', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });
    }
};
