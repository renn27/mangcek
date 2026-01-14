<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PencatatanUsaha extends Model
{
    protected $table = 'pencatatan_usaha';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'kode_nama_usaha',
        'status_usaha',
        'alamat',
        'rw',
        'rt',
        'photo_path',
        'latitude',
        'longitude',
        'nama_petugas',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
    public function usaha()
    {
        return $this->belongsTo(NamaUsaha::class, 'kode_nama_usaha', 'kode_nama_usaha');
    }
}
