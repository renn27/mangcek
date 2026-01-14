<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\NamaUsaha;
use App\Models\Kecamatan;
use App\Models\Desa;



class WilayahController extends Controller
{
    public function kecamatan()
    {
        return DB::table('kecamatan')
            ->select('kode_kecamatan', 'nama_kecamatan')
            ->orderBy('nama_kecamatan')
            ->get();
    }

    public function desa($kode_kecamatan)
    {
        return DB::table('desa')
            ->where('kode_kecamatan', $kode_kecamatan)
            ->select('kode_desa', 'nama_desa')
            ->orderBy('nama_desa')
            ->get();
    }

    public function searchUsaha(Request $request)
{
    return DB::table('nama_usaha as nu')
        ->leftJoin('pencatatan_usaha as pu', 'nu.kode_nama_usaha', '=', 'pu.kode_nama_usaha')
        ->whereNull('pu.kode_nama_usaha') // ❗ BELUM PERNAH DICATAT
        ->where('nu.kode_desa', $request->kode_desa) // ❗ SESUAI DESA
        ->where('nu.nama_usaha', 'like', '%' . $request->q . '%')
        ->limit(10)
        ->get([
            'nu.kode_nama_usaha',
            'nu.nama_usaha'
        ]);
}


    public function detailUsaha($kode)
    {
        $usaha = NamaUsaha::where('kode_nama_usaha', $kode)->first();

        if (!$usaha) {
            return response()->json([], 404);
        }

        return response()->json([
            'alamat' => $usaha->alamat,
            'status_profiling_sbr' => $usaha->status_profiling_sbr,
        ]);
    }
}
