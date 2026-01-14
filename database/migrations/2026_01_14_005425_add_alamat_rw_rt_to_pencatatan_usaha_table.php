<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlamatRwRtToPencatatanUsahaTable extends Migration
{
    public function up()
    {
        Schema::table('pencatatan_usaha', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('status_usaha');
            $table->string('rw')->nullable()->after('alamat');
            $table->string('rt')->nullable()->after('rw');
        });
    }

    public function down()
    {
        Schema::table('pencatatan_usaha', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'rw', 'rt']);
        });
    }
}
