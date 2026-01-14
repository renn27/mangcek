<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NamaUsahaSeeder extends Seeder
{
    public function run(): void
    {
        $desaList = DB::table('desa')->get();

        $profilingStatus = [
            'tidak_ditemukan',
            'ditemukan',
            'tutup',
            'ganda',
        ];

        $jenisUsaha = [
            'Toko Sembako',
            'Warung Makan',
            'Bengkel Motor',
            'Laundry',
            'Counter HP',
            'Toko Bangunan',
            'Fotokopi',
            'Cafe',
            'Usaha Jahit',
            'Salon',
        ];

        $namaBrand = [
            'Sumber Rejeki',
            'Maju Jaya',
            'Makmur',
            'Jaya Abadi',
            'Berkah',
            'Sejahtera',
            'Sinar Baru',
            'Anugrah',
            'Sentosa',
            'Karya Mandiri',
        ];

        $data = [];

        foreach ($desaList as $desa) {

            $namaTerpakai = [];

            /**
             * 1️⃣ WAJIB: 1 usaha untuk setiap jenis usaha
             */
            foreach ($jenisUsaha as $jenis) {

                do {
                    $namaUsaha = $jenis . ' ' . $namaBrand[array_rand($namaBrand)];
                } while (in_array($namaUsaha, $namaTerpakai));

                $namaTerpakai[] = $namaUsaha;

                $data[] = [
                    'kode_nama_usaha'       => 'NU-' . strtoupper(Str::random(10)),
                    'kode_kecamatan'       => $desa->kode_kecamatan,
                    'kode_desa'            => $desa->kode_desa,
                    'nama_usaha'           => $namaUsaha,
                    'alamat'               => "Jl. {$desa->nama_desa} No. " . rand(1, 200),
                    'status_profiling_sbr' => $profilingStatus[array_rand($profilingStatus)],
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ];
            }

            /**
             * 2️⃣ OPSIONAL: tambahan 0–2 usaha (jenis boleh sama)
             */
            $tambahan = rand(0, 2);

            for ($i = 0; $i < $tambahan; $i++) {

                do {
                    $namaUsaha =
                        $jenisUsaha[array_rand($jenisUsaha)]
                        . ' '
                        . $namaBrand[array_rand($namaBrand)];
                } while (in_array($namaUsaha, $namaTerpakai));

                $namaTerpakai[] = $namaUsaha;

                $data[] = [
                    'kode_nama_usaha'       => 'NU-' . strtoupper(Str::random(10)),
                    'kode_kecamatan'       => $desa->kode_kecamatan,
                    'kode_desa'            => $desa->kode_desa,
                    'nama_usaha'           => $namaUsaha,
                    'alamat'               => "Jl. {$desa->nama_desa} No. " . rand(1, 200),
                    'status_profiling_sbr' => $profilingStatus[array_rand($profilingStatus)],
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ];
            }
        }

        DB::table('nama_usaha')->insert($data);
    }
}
