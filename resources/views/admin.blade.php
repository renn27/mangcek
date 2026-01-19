@extends('layouts.app')

@section('title', 'Admin - CRUD Pencatatan Usaha')

@section('content')
    <div class="px-4 pb-2">
        <div
                class="bg-gradient-to-r from-gray-50 to-white shadow-md rounded-b-lg mb-6 py-2 px-4 border-b border-gray-200">
                <div class="flex items-center justify-between max-w-6xl mx-auto">
                    <!-- Logo Kiri -->
                    <div class="flex items-center space-x-2 flex-shrink-0">
                        <div class="bg-white p-1 rounded-lg shadow-sm border border-gray-200">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/Lambang_Badan_Pusat_Statistik_%28BPS%29_Indonesia.svg/2560px-Lambang_Badan_Pusat_Statistik_%28BPS%29_Indonesia.svg.png"
                                alt="Logo BPS" class="w-8 h-8 object-contain"
                                onerror="this.src='https://via.placeholder.com/32x32/ccc/666?text=BPS';">
                        </div>
                    </div>

                    <!-- Judul Tengah dengan warna #f79039 dan #febd26 -->
                    <div class="text-center flex-1 min-w-0 mx-2">
                        <h1
                            class="text-lg md:text-2xl lg:text-3xl font-bold tracking-tight whitespace-nowrap overflow-hidden text-ellipsis">
                            <span style="color: #f79039" class="inline-block">MANGCEK</span>
                            <span style="color: #febd26" class="inline-block ml-1 md:ml-2">SE2026</span>
                        </h1>
                        <div
                            class="mt-0 md:mt-1 text-gray-600 text-xs md:text-sm whitespace-nowrap overflow-hidden text-ellipsis px-1">
                            (Mitra Bantu Ground Check)
                        </div>
                    </div>

                    <!-- Logo Kanan -->
                    <div class="flex items-center space-x-2 flex-shrink-0">
                        <div class="bg-white p-1 rounded-lg shadow-sm border border-gray-200">
                            <img src="{{ asset('images/logo-se2026.png') }}" alt="Logo SE2026"
                                class="w-8 h-8 object-contain"
                                onerror="this.src='https://via.placeholder.com/32x32/ccc/666?text=SE2026';">
                        </div>
                    </div>
                </div>
            </div>

        <!-- Card untuk tabel -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-sm font-medium text-gray-700">Daftar Pencatatan Usaha</h2>
                        <p class="text-gray-500 text-xs mt-0.5">Total data: <span id="totalRecords"
                                class="font-medium">0</span>
                            entri</p>
                    </div>
                    <button onclick="exportToCSV()"
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded text-xs flex items-center transition-all duration-200">
                        <i class="fas fa-file-csv mr-1 text-xs"></i> Export CSV
                    </button>
                </div>
            </div>

            <div>
                <div class="overflow-x-auto rounded border border-gray-200 px-3">
                    <table class="min-w-full text-xs" id="dataTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    No</th>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    Nama Usaha</th>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    Kecamatan</th>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    Desa</th>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    Status</th>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    Alamat</th>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    RT</th>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    RW</th>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    Latitude</th>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    Longitude</th>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    Foto</th>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    Petugas</th>
                                <th
                                    class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                    Tanggal</th>
                                <th class="px-3 py-2 text-center font-medium text-gray-700 uppercase tracking-wider">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Data akan diisi oleh DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white rounded-lg shadow-lg w-full max-w-sm mx-auto">
                    <!-- Header -->
                    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900">Edit Pencatatan Usaha</h3>
                            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                        <p class="text-gray-500 text-xs mt-0.5">Perbarui data pencatatan usaha</p>
                    </div>

                    <!-- Body -->
                    <div class="px-4 py-3 max-h-[60vh] overflow-y-auto">
                        <form id="editForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit_id" name="id">

                            <div class="space-y-3">
                                <!-- Kode Usaha -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        Kode Nama Usaha <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="edit_kode_nama_usaha" name="kode_nama_usaha" required
                                        class="w-full px-3 py-2 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-primary focus:border-primary">
                                </div>

                                <!-- Status Usaha -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        Status Usaha <span class="text-red-500">*</span>
                                    </label>
                                    <select id="edit_status_usaha" name="status_usaha" required
                                        class="w-full px-3 py-2 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-primary focus:border-primary appearance-none bg-white">
                                        <option value="tidak_ditemukan">Tidak Ditemukan</option>
                                        <option value="ditemukan">Ditemukan</option>
                                        <option value="tutup">Tutup</option>
                                        <option value="ganda">Ganda</option>
                                    </select>
                                </div>

                                <!-- Alamat -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        Alamat <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="edit_alamat" name="alamat" rows="2" required
                                        class="w-full px-3 py-2 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-primary focus:border-primary resize-none"></textarea>
                                </div>

                                <!-- RT & RW -->
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">
                                            RT <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="edit_rt" name="rt" required maxlength="10"
                                            class="w-full px-3 py-2 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-primary focus:border-primary text-center">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">
                                            RW <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="edit_rw" name="rw" required maxlength="10"
                                            class="w-full px-3 py-2 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-primary focus:border-primary text-center">
                                    </div>
                                </div>

                                <!-- Latitude & Longitude -->
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">
                                            Latitude
                                        </label>
                                        <input type="number" step="any" id="edit_latitude" name="latitude"
                                            class="w-full px-3 py-2 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-primary focus:border-primary">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">
                                            Longitude
                                        </label>
                                        <input type="number" step="any" id="edit_longitude" name="longitude"
                                            class="w-full px-3 py-2 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-primary focus:border-primary">
                                    </div>
                                </div>

                                <!-- Nama Petugas -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        Nama Petugas <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="edit_nama_petugas" name="nama_petugas" required
                                        class="w-full px-3 py-2 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-primary focus:border-primary">
                                </div>

                                <!-- Foto -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        Foto Usaha (Opsional)
                                    </label>
                                    <div class="border border-dashed border-gray-300 rounded p-2 text-center">
                                        <input type="file" id="edit_photo" name="photo" accept="image/*"
                                            class="hidden" onchange="previewFileName(this)">
                                        <label for="edit_photo" class="cursor-pointer">
                                            <i class="fas fa-camera text-lg text-gray-400 mb-1"></i>
                                            <p class="text-xs text-gray-600">Klik untuk upload foto</p>
                                            <p class="text-xs text-gray-500 mt-0.5">Maks 2MB (JPG, PNG, JPEG)</p>
                                        </label>
                                        <div id="fileName" class="text-xs text-primary mt-1 hidden"></div>
                                    </div>

                                    <!-- Current Photo -->
                                    <div id="current_photo_container" class="mt-2 hidden">
                                        <p class="text-xs font-medium text-gray-700 mb-1">Foto saat ini:</p>
                                        <div id="current_photo"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="px-4 py-3 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeEditModal()"
                                class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                                Batal
                            </button>
                            <button type="submit" form="editForm"
                                class="px-3 py-1.5 text-xs font-medium text-white bg-primary border border-transparent rounded hover:bg-orange-600">
                                Update Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Tabel styling - NO FIXED WIDTHS */
            #dataTable th,
            #dataTable td {
                white-space: nowrap;
                vertical-align: middle;
                font-size: 0.75rem;
            }

            #dataTable th {
                background-color: #f9fafb;
                font-weight: 500;
                padding: 8px 12px;
            }

            #dataTable td {
                padding: 8px 12px;
                border-color: #e5e7eb;
            }

            #dataTable tbody tr:hover {
                background-color: #f9fafb;
            }

            /* Modal styling */
            #editModal .max-h-\[60vh\] {
                max-height: 60vh;
            }

            #editModal .max-h-\[60vh\]::-webkit-scrollbar {
                width: 4px;
            }

            #editModal .max-h-\[60vh\]::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            #editModal .max-h-\[60vh\]::-webkit-scrollbar-thumb {
                background: #cbd5e0;
            }

            /* Status badges */
            .status-badge {
                padding: 2px 6px;
                border-radius: 12px;
                font-size: 0.7rem;
                font-weight: 500;
                display: inline-block;
            }

            .status-tidak_ditemukan {
                background-color: #fee2e2;
                color: #991b1b;
            }

            .status-ditemukan {
                background-color: #dcfce7;
                color: #166534;
            }

            .status-tutup {
                background-color: #fef3c7;
                color: #92400e;
            }

            .status-ganda {
                background-color: #dbeafe;
                color: #1e40af;
            }

            /* DataTables customization */
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 4px 8px;
                margin: 0 1px;
                border-radius: 4px;
                border: 1px solid #e5e7eb;
                font-size: 0.75rem;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: #f79039;
                color: white !important;
                border-color: #f79039;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.0/papaparse.min.js"></script>
        <script>
            // File name preview
            function previewFileName(input) {
                const fileNameDiv = document.getElementById('fileName');
                if (input.files && input.files[0]) {
                    fileNameDiv.textContent = 'File: ' + input.files[0].name;
                    fileNameDiv.classList.remove('hidden');
                } else {
                    fileNameDiv.classList.add('hidden');
                }
            }

            // Modal Functions
            function openEditModal() {
                document.getElementById('editModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeEditModal() {
                document.getElementById('editModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
                document.getElementById('fileName').classList.add('hidden');
            }

            // Export to CSV function - Menggunakan data mentah dari route baru
            // Export to CSV function - PERBAIKAN LENGKAP
            function exportToCSV() {
                $.ajax({
                    url: "{{ route('pencatatan.index') }}",
                    type: 'GET',
                    data: {
                        draw: 1,
                        start: 0,
                        length: -1
                    },
                    success: function(response) {
                        var data = response.data;
                        var csvData = [];

                        // Header
                        csvData.push([
                            'No',
                            'Nama Usaha',
                            'Kecamatan',
                            'Desa',
                            'Status',
                            'Alamat',
                            'RT',
                            'RW',
                            'Latitude',
                            'Longitude',
                            'Link Foto',
                            'Petugas',
                            'Tanggal'
                        ]);

                        // Data rows
                        data.forEach(function(row, index) {
                            // Fungsi untuk membersihkan data dari HTML tags
                            function cleanData(value) {
                                if (!value) return '';

                                var str = String(value);

                                // Jika berisi HTML span, return string kosong atau '-'
                                if (str.includes('<span') || str.includes('</span>')) {
                                    return '';
                                }

                                // Jika berisi HTML tag lain, extract teks saja
                                if (str.includes('<')) {
                                    // Hapus semua HTML tags
                                    str = str.replace(/<[^>]*>/g, '');
                                }

                                return str.trim();
                            }

                            // Clean photo path
                            var photoLink = '';
                            if (row.photo_path) {
                                var cleanPath = row.photo_path;
                                // Jika berisi HTML tag, extract path-nya
                                if (cleanPath.includes('href=')) {
                                    var match = cleanPath.match(/href="([^"]+)"/);
                                    if (match) cleanPath = match[1];
                                }
                                // Hapus HTML tags lainnya
                                cleanPath = cleanPath.replace(/<[^>]*>/g, '');
                                // Buat URL lengkap jika masih ada isinya
                                if (cleanPath.trim() !== '') {
                                    photoLink = window.location.origin + cleanPath;
                                }
                            }

                            var statusText = '';
                            switch (row.status_usaha) {
                                case 'tidak_ditemukan':
                                    statusText = 'Tidak Ditemukan';
                                    break;
                                case 'ditemukan':
                                    statusText = 'Ditemukan';
                                    break;
                                case 'tutup':
                                    statusText = 'Tutup';
                                    break;
                                case 'ganda':
                                    statusText = 'Ganda';
                                    break;
                            }

                            csvData.push([
                                index + 1,
                                cleanData(row.nama_usaha_text || row.kode_nama_usaha),
                                cleanData(row.nama_kecamatan),
                                cleanData(row.nama_desa),
                                statusText,
                                cleanData(row.alamat),
                                cleanData(row.rt),
                                cleanData(row.rw),
                                cleanData(row.latitude), // Sudah bersih dari HTML
                                cleanData(row.longitude), // Sudah bersih dari HTML
                                photoLink,
                                cleanData(row.nama_petugas),
                                new Date(row.created_at).toLocaleDateString('id-ID', {
                                    day: '2-digit',
                                    month: 'short',
                                    year: 'numeric'
                                })
                            ]);
                        });

                        // Convert to CSV
                        var csv = Papa.unparse(csvData);

                        // Create download link
                        var blob = new Blob([csv], {
                            type: 'text/csv;charset=utf-8;'
                        });
                        var link = document.createElement("a");
                        var url = URL.createObjectURL(blob);

                        link.setAttribute("href", url);
                        link.setAttribute("download", "pencatatan_usaha_" + new Date().toISOString().slice(0, 10) +
                            ".csv");
                        link.style.visibility = 'hidden';

                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil diexport ke CSV',
                            timer: 2000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end',
                            width: 300
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal mengexport data',
                            toast: true,
                            position: 'top-end',
                            width: 300
                        });
                    }
                });
            }

            // Initialize DataTable - AUTO WIDTH ENABLED
            $(document).ready(function() {
                var table = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('pencatatan.index') }}",
                        dataSrc: function(json) {
                            $('#totalRecords').text(json.recordsTotal);
                            return json.data;
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'kode_nama_usaha',
                            name: 'nama_usaha.nama_usaha',
                            className: 'font-medium'
                        },
                        {
                            data: 'nama_kecamatan',
                            name: 'kecamatan.nama_kecamatan',
                            render: function(data) {
                                return data || '<span class="text-gray-400">-</span>';
                            }
                        },
                        {
                            data: 'nama_desa',
                            name: 'desa.nama_desa',
                            render: function(data) {
                                return data || '<span class="text-gray-400">-</span>';
                            }
                        },
                        {
                            data: 'status_usaha',
                            name: 'status_usaha',
                            className: 'text-center',
                            render: function(data) {
                                const statusMap = {
                                    'tidak_ditemukan': '<span class="status-badge status-tidak_ditemukan">Tdk Ditemukan</span>',
                                    'ditemukan': '<span class="status-badge status-ditemukan">Ditemukan</span>',
                                    'tutup': '<span class="status-badge status-tutup">Tutup</span>',
                                    'ganda': '<span class="status-badge status-ganda">Ganda</span>'
                                };
                                return statusMap[data] || data;
                            }
                        },
                        {
                            data: 'alamat',
                            name: 'alamat'
                        },
                        {
                            data: 'rt',
                            name: 'rt',
                            className: 'text-center'
                        },
                        {
                            data: 'rw',
                            name: 'rw',
                            className: 'text-center'
                        },
                        {
                            data: 'latitude',
                            name: 'latitude',
                            className: 'text-center',
                            render: function(data) {
                                return data || '<span class="text-gray-400">-</span>';
                            }
                        },
                        {
                            data: 'longitude',
                            name: 'longitude',
                            className: 'text-center',
                            render: function(data) {
                                return data || '<span class="text-gray-400">-</span>';
                            }
                        },
                        {
                            data: 'photo_path',
                            name: 'photo_path',
                            orderable: false,
                            className: 'text-center',
                            render: function(data, type, row) {

                                // 🔒 AMAN TOTAL: cek null, '-', dan HTML span
                                if (
                                    !data ||
                                    data === '-' ||
                                    data.includes('<span') ||
                                    data.trim() === ''
                                ) {
                                    return '<span class="text-gray-400">-</span>';
                                }

                                let photoUrl = data;

                                // Jika HTML <a>, extract href
                                if (typeof data === 'string' && data.includes('href=')) {
                                    const match = data.match(/href="([^"]+)"/);
                                    if (match) {
                                        photoUrl = match[1];
                                    }
                                }

                                // Normalisasi path
                                if (!photoUrl.startsWith('http') && !photoUrl.startsWith('/')) {
                                    photoUrl = '/storage/' + photoUrl;
                                }

                                return `
            <a href="${photoUrl}" target="_blank"
               class="inline-flex items-center space-x-1 bg-white border border-gray-300 rounded px-2 py-1 hover:bg-gray-50 text-xs">
                <i class="fas fa-eye text-blue-600"></i>
                <span class="text-blue-600">Lihat</span>
            </a>
        `;
                            }
                        },

                        {
                            data: 'nama_petugas',
                            name: 'nama_petugas',
                            className: 'font-medium'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            className: 'text-center',
                            render: function(data) {
                                return new Date(data).toLocaleDateString('id-ID', {
                                    day: '2-digit',
                                    month: 'short',
                                    year: 'numeric'
                                });
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `
                            <div class="flex justify-center space-x-1">
                                <button class="edit-btn bg-blue-100 text-blue-700 hover:bg-blue-200 rounded p-1" data-id="${row.id}" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <button class="delete-btn bg-red-100 text-red-700 hover:bg-red-200 rounded p-1" data-id="${row.id}" title="Hapus">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        `;
                            }
                        }
                    ],
                    order: [
                        [12, 'desc']
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "→",
                            previous: "←"
                        }
                    },
                    dom: '<"flex justify-between items-center p-2"<"text-xs"l><"text-xs"f>>rt<"flex justify-between items-center p-2"<"text-xs text-gray-600"i><"text-xs"p>>',
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "Semua"]
                    ],
                    responsive: true,
                    scrollX: false,
                    autoWidth: true, // INI YANG PENTING: Biarkan kolom menyesuaikan lebar data
                    drawCallback: function(settings) {
                        $('#totalRecords').text(settings.json ? settings.json.recordsTotal : 0);
                    },
                    initComplete: function() {
                        $('.dataTables_filter input').addClass(
                            'px-2 py-1 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-primary focus:border-primary'
                        );
                        $('.dataTables_length select').addClass(
                            'px-2 py-1 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-primary focus:border-primary'
                        );
                    }
                });

                // Handle edit button click - FIXED PHOTO PATH BUG
                $(document).on('click', '.edit-btn', function() {
                    var id = $(this).data('id');

                    $.ajax({
                        url: "{{ route('pencatatan.edit', ':id') }}".replace(':id', id),
                        type: 'GET',
                        success: function(response) {
                            $('#edit_id').val(response.id);
                            $('#edit_kode_nama_usaha').val(response.kode_nama_usaha);
                            $('#edit_status_usaha').val(response.status_usaha);
                            $('#edit_alamat').val(response.alamat);
                            $('#edit_rt').val(response.rt);
                            $('#edit_rw').val(response.rw);
                            $('#edit_latitude').val(response.latitude);
                            $('#edit_longitude').val(response.longitude);
                            $('#edit_nama_petugas').val(response.nama_petugas);

                            // Display current photo if exists - FIXED BUG
                            if (response.photo_path) {
                                // PERBAIKAN: Gunakan logika yang sama dengan tabel
                                var photoUrl = response.photo_path.startsWith('http') ? response
                                    .photo_path :
                                    (response.photo_path.startsWith('/') ? response.photo_path :
                                        '/storage/' + response.photo_path);

                                $('#current_photo').html(`
                            <a href="${photoUrl}" target="_blank" 
                               class="inline-flex items-center space-x-1 bg-white border border-gray-300 rounded px-2 py-1 hover:bg-gray-50 text-xs">
                                <i class="fas fa-eye text-blue-600"></i>
                                <span class="text-blue-600">Lihat Foto</span>
                            </a>
                        `);
                                $('#current_photo_container').removeClass('hidden');
                            } else {
                                $('#current_photo').html(
                                    '<span class="text-gray-500 text-xs">Tidak ada foto</span>');
                                $('#current_photo_container').addClass('hidden');
                            }

                            openEditModal();
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Gagal memuat data',
                                toast: true,
                                position: 'top-end',
                                width: 300
                            });
                        }
                    });
                });

                // Handle edit form submission
                $('#editForm').submit(function(e) {
                    e.preventDefault();

                    var id = $('#edit_id').val();
                    var formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('pencatatan.update', ':id') }}".replace(':id', id),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-HTTP-Method-Override': 'PUT'
                        },
                        success: function(response) {
                            closeEditModal();
                            table.ajax.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.success,
                                timer: 1500,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end',
                                width: 300
                            });
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';

                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '\n';
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: errorMessage,
                                toast: true,
                                position: 'top-end',
                                width: 300
                            });
                        }
                    });
                });

                // Handle delete button click
                $(document).on('click', '.delete-btn', function() {
                    var id = $(this).data('id');

                    Swal.fire({
                        title: 'Hapus Data?',
                        text: "Data akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f79039',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        width: 300
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('pencatatan.destroy', ':id') }}".replace(':id',
                                    id),
                                type: 'DELETE',
                                data: {
                                    '_token': "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if (response.success) {
                                        table.ajax.reload();

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: response.message,
                                            timer: 1500,
                                            showConfirmButton: false,
                                            toast: true,
                                            position: 'top-end',
                                            width: 300
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal!',
                                            text: response.message,
                                            toast: true,
                                            position: 'top-end',
                                            width: 300
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: 'Terjadi kesalahan saat menghapus data',
                                        toast: true,
                                        position: 'top-end',
                                        width: 300
                                    });
                                }
                            });
                        }
                    });
                });

                // Close modal when clicking outside
                window.onclick = function(event) {
                    var editModal = document.getElementById('editModal');
                    if (event.target == editModal) {
                        closeEditModal();
                    }
                }
            });
        </script>
    @endpush
@endsection
