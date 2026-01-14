<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PencatatanUsaha;
use Illuminate\Support\Str;
use DataTables;

class PencatatanUsahaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kode_nama_usaha' => [
                'required',
                'exists:nama_usaha,kode_nama_usaha',
                'unique:pencatatan_usaha,kode_nama_usaha'
            ],
            'status_usaha'    => 'required|in:tidak_ditemukan,ditemukan,tutup,ganda',
            'alamat'          => 'required|string',
            'rw'              => 'required|string|max:10',
            'rt'              => 'required|string|max:10',
            'photo'           => 'nullable|image|max:2048',
            'latitude'        => 'nullable|numeric',
            'longitude'       => 'nullable|numeric',
            'nama_petugas'    => 'required|string',
        ]);

        // upload foto (jika ada)
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('foto-usaha', 'public');
        }

        PencatatanUsaha::create([
            'id'              => Str::uuid(),
            'kode_nama_usaha' => $request->kode_nama_usaha,
            'status_usaha'    => $request->status_usaha,
            'alamat'          => $request->alamat,
            'rw'              => $request->rw,
            'rt'              => $request->rt,
            'photo_path'      => $photoPath,
            'latitude'        => $request->latitude,
            'longitude'       => $request->longitude,
            'nama_petugas'    => $request->nama_petugas,
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PencatatanUsaha::select([
                'pencatatan_usaha.*',
                'nama_usaha.nama_usaha as nama_usaha_text',
                'desa.nama_desa',
                'kecamatan.nama_kecamatan'
            ])
                ->leftJoin('nama_usaha', 'pencatatan_usaha.kode_nama_usaha', '=', 'nama_usaha.kode_nama_usaha')
                ->leftJoin('desa', 'nama_usaha.kode_desa', '=', 'desa.kode_desa')
                ->leftJoin('kecamatan', 'nama_usaha.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')
                ->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="flex justify-center space-x-1">';
                    $btn .= '<button type="button" class="edit-btn bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs" data-id="' . $row->id . '" title="Edit"><i class="fas fa-edit"></i></button>';
                    $btn .= '<button type="button" class="delete-btn bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs" data-id="' . $row->id . '" title="Hapus"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->editColumn('kode_nama_usaha', function ($row) {
                    return $row->nama_usaha_text ?? '<span class="text-gray-500">' . $row->kode_nama_usaha . '</span>';
                })
                ->editColumn('photo_path', function ($row) {
                    if ($row->photo_path) {
                        return '<a href="/storage/' . $row->photo_path . '" target="_blank" class="text-xs text-blue-600 hover:text-blue-800 px-2 py-1 border border-blue-300 rounded inline-block">Lihat Foto</a>';
                    }
                    return '<span class="text-gray-400">-</span>';
                })
                ->editColumn('latitude', function ($row) {
                    return $row->latitude ?: '<span class="text-gray-400">-</span>';
                })
                ->editColumn('longitude', function ($row) {
                    return $row->longitude ?: '<span class="text-gray-400">-</span>';
                })
                ->filter(function ($query) use ($request) {
                    if (!empty($request->get('search')['value'])) {
                        $search = $request->get('search')['value'];
                        $query->where(function ($q) use ($search) {
                            $q->where('pencatatan_usaha.kode_nama_usaha', 'LIKE', "%{$search}%")
                                ->orWhere('nama_usaha.nama_usaha', 'LIKE', "%{$search}%")
                                ->orWhere('desa.nama_desa', 'LIKE', "%{$search}%")
                                ->orWhere('kecamatan.nama_kecamatan', 'LIKE', "%{$search}%")
                                ->orWhere('pencatatan_usaha.alamat', 'LIKE', "%{$search}%")
                                ->orWhere('pencatatan_usaha.nama_petugas', 'LIKE', "%{$search}%")
                                ->orWhere('pencatatan_usaha.rt', 'LIKE', "%{$search}%")
                                ->orWhere('pencatatan_usaha.rw', 'LIKE', "%{$search}%");
                        });
                    }
                })
                ->rawColumns(['action', 'kode_nama_usaha', 'photo_path', 'latitude', 'longitude'])
                ->make(true);
        }

        return view('admin');
    }

    public function edit($id)
    {
        $item = PencatatanUsaha::select([
            'pencatatan_usaha.*',
            'nama_usaha.nama_usaha as nama_usaha_text',
            'nama_usaha.kode_desa',
            'nama_usaha.kode_kecamatan',
            'desa.nama_desa',
            'kecamatan.nama_kecamatan'
        ])
            ->leftJoin('nama_usaha', 'pencatatan_usaha.kode_nama_usaha', '=', 'nama_usaha.kode_nama_usaha')
            ->leftJoin('desa', 'nama_usaha.kode_desa', '=', 'desa.kode_desa')
            ->leftJoin('kecamatan', 'nama_usaha.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')
            ->findOrFail($id);

        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_nama_usaha' => 'required|exists:nama_usaha,kode_nama_usaha',
            'status_usaha'    => 'required|in:tidak_ditemukan,ditemukan,tutup,ganda',
            'alamat'          => 'required|string',
            'rw'              => 'required|string|max:10',
            'rt'              => 'required|string|max:10',
            'photo'           => 'nullable|image|max:2048',
            'latitude'        => 'nullable|numeric',
            'longitude'       => 'nullable|numeric',
            'nama_petugas'    => 'required|string',
        ]);

        $item = PencatatanUsaha::findOrFail($id);

        if ($request->hasFile('photo')) {
            $item->photo_path = $request->file('photo')->store('foto-usaha', 'public');
        }

        $item->update($request->only([
            'kode_nama_usaha',
            'status_usaha',
            'alamat',
            'rw',
            'rt',
            'latitude',
            'longitude',
            'nama_petugas',
        ]));

        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        try {
            $item = PencatatanUsaha::findOrFail($id);
            $item->delete();

            // Kembalikan response JSON untuk AJAX
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            // Kembalikan error response untuk AJAX
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
