<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;

class NamaUsahaImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public int $totalExcel = 0;
    public int $inserted = 0;
    public array $skipped = [];

    public function collection(Collection $rows)
    {
        $this->totalExcel += $rows->count();
        $data = [];

        // Ambil semua kode desa & kecamatan dari DB sekaligus
        $desaValid = DB::table('desa')->pluck('kode_desa')->toArray();
        $kecValid  = DB::table('kecamatan')->pluck('kode_kecamatan')->toArray();

        foreach ($rows as $row) {
            $kodeDesa = trim($row['kode_desa'] ?? '');
            $kodeKec  = trim($row['kode_kecamatan'] ?? '');
            $kodeUsaha= trim($row['kode_nama_usaha'] ?? '');
            $namaUsaha= trim($row['nama_usaha'] ?? '');
            $alamat   = trim($row['alamat'] ?? '');
            $latitude = trim($row['latitude'] ?? '');
            $longitude = trim($row['longitude'] ?? '');
            $profiling= trim($row['status_profiling_sbr'] ?? '');

            // Validasi wajib
            if (!$kodeUsaha || !$namaUsaha) {
                $this->skipped[] = ['kode'=>$kodeUsaha, 'alasan'=>'Field wajib kosong'];
                continue;
            }

            // Validasi FK
            if (!in_array($kodeDesa, $desaValid)) {
                $this->skipped[] = ['kode'=>$kodeUsaha, 'alasan'=>'desa tidak valid'];
                continue;
            }
            if (!in_array($kodeKec, $kecValid)) {
                $this->skipped[] = ['kode'=>$kodeUsaha, 'alasan'=>'kecamatan tidak valid'];
                continue;
            }

            // Validasi panjang field
            if (mb_strlen($namaUsaha) > 255 || mb_strlen($alamat) > 255 || mb_strlen($profiling) > 50) {
                $this->skipped[] = ['kode'=>$kodeUsaha,'alasan'=>'field terlalu panjang'];
                continue;
            }

            $data[] = [
                'kode_nama_usaha'       => substr($kodeUsaha, 0, 50),
                'kode_desa'             => substr($kodeDesa, 0, 50),
                'kode_kecamatan'        => substr($kodeKec, 0, 50),
                'nama_usaha'            => mb_substr($namaUsaha, 0, 255),
                'alamat'                => mb_substr($alamat, 0, 255),
                'latitude'                => mb_substr($latitude, 0, 255),
                'longitude'                => mb_substr($longitude, 0, 255),
                'status_profiling_sbr'  => mb_substr($profiling, 0, 50),
                'created_at'            => now(),
                'updated_at'            => now(),
            ];
        }

        // Bulk insert pakai chunk 1000 → ultra cepat
        $chunks = array_chunk($data, 1000);
        foreach ($chunks as $chunk) {
            DB::table('nama_usaha')->insert($chunk);
            $this->inserted += count($chunk);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
