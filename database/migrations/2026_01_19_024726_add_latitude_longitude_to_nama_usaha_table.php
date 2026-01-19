<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatitudeLongitudeToNamaUsahaTable extends Migration
{
    public function up()
    {
        Schema::table('nama_usaha', function (Blueprint $table) {
            // Menambahkan kolom latitude dan longitude setelah kolom 'alamat'
            $table->decimal('latitude', 10, 7)->nullable()->after('alamat');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });
    }

    public function down()
    {
        Schema::table('nama_usaha', function (Blueprint $table) {
            // Menghapus kolom jika rollback
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
}
