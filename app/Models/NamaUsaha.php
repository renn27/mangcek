<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NamaUsaha extends Model
{
    protected $table = 'nama_usaha';

    protected $primaryKey = 'kode_nama_usaha';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'kode_nama_usaha',
        'kode_desa',
        'kode_kecamatan',
        'nama_usaha',
        'alamat',
        'latitude',
        'longitude',
        'status_profiling_sbr',
    ];

    public $timestamps = false;
}
