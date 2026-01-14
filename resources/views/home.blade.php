@extends('layouts.app')

@section('title', 'MANGCEK - Mitra Bantu Ground CEK')

@section('content')

    {{-- alert --}}
    @if (session('success'))
        <div id="successModal"
            class="fixed inset-0 flex items-center justify-center z-50 pointer-events-none opacity-0 transition-opacity duration-300">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black bg-opacity-30 pointer-events-auto"></div>

            <!-- Modal Card -->
            <div
                class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6 z-50 pointer-events-auto transform translate-y-4 transition-all duration-300">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-green-700">Sukses!</h3>
                    <button id="closeModal" class="text-gray-500 font-bold">&times;</button>
                </div>
                <p class="text-gray-700">{{ session('success') }}</p>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('successModal');
                const modalCard = modal.querySelector('div.bg-white');
                const closeBtn = document.getElementById('closeModal');

                // Fade in
                requestAnimationFrame(() => {
                    modal.classList.remove('opacity-0');
                    modalCard.classList.remove('translate-y-4');
                });

                // Auto fade out after 4 detik
                setTimeout(() => {
                    modal.classList.add('opacity-0');
                    modalCard.classList.add('translate-y-4');
                    modalCard.addEventListener('transitionend', () => modal.remove());
                }, 4000);

                // Close manual
                closeBtn.addEventListener('click', () => {
                    modal.classList.add('opacity-0');
                    modalCard.classList.add('translate-y-4');
                    modalCard.addEventListener('transitionend', () => modal.remove());
                });
            });
        </script>
    @endif


    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 px-4 py-2">
        <!-- Header dengan logo dari link -->
        <div class="flex items-center justify-between mb-4 pt-2 px-4">
            <!-- Logo Kiri dari PNGEgg -->
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/Lambang_Badan_Pusat_Statistik_%28BPS%29_Indonesia.svg/2560px-Lambang_Badan_Pusat_Statistik_%28BPS%29_Indonesia.svg.png"
                alt="Logo Kiri" class="w-12 h-12 object-contain"
                onerror="this.src='https://via.placeholder.com/48x48/ccc/666?text=Logo+Kiri';">

            <!-- Judul Tengah -->
            <div class="text-center mx-4 flex-1"> <!-- mx-4 = margin kiri-kanan -->
                <h1 class="text-2xl font-bold text-primary">MANGCEK SE2026</h1>
                <p class="text-gray-600 text-sm mt-1">(Mitra Bantu Ground Check)</p>
            </div>

            <!-- Logo Kanan dari BPS -->
            <img src= "{{ asset('images/logo-se2026.png') }}" alt="Logo BPS" class="w-12 h-12 object-contain"
                onerror="this.src='https://via.placeholder.com/48x48/ccc/666?text=Logo+BPS';">
        </div>

        <!-- Form Utama -->
        <form id="mangcekForm" action="{{ route('pencatatan.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-4 max-w-md mx-auto pb-6">
            @csrf

            <!-- Data Hasil SBR 2025 Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="bg-primary text-white px-4 py-3">
                    <h2 class="font-bold text-sm">Data Hasil SBR 2025</h2>
                </div>
                <div class="p-4 space-y-4">
                    <!-- Input Kecamatan -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Kecamatan <span class="text-red-500">*</span>
                        </label>
                        <select
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-white"
                            id="kecamatan" required>
                            <option value="" selected disabled class="text-gray-400">Pilih Kecamatan</option>
                        </select>
                    </div>

                    <!-- Input Desa/Kelurahan -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Desa/Kelurahan <span class="text-red-500">*</span>
                        </label>
                        <select
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-white"
                            id="desa" required>
                            <option value="" selected disabled class="text-gray-400">Pilih Desa/Kelurahan</option>
                        </select>
                    </div>

                    <!-- Input Nama Usaha -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Nama Usaha <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="usahaSearch" placeholder="Cari Nama Usaha..."
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">

                            <ul id="usahaResult"
                                class="absolute z-10 w-full bg-white border border-gray-300 rounded-lg mt-1 hidden max-h-48 overflow-y-auto">
                            </ul>

                            <input type="hidden" id="kode_usaha" name="kode_nama_usaha">
                        </div>
                    </div>

                    <!-- Input Alamat -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Usaha</label>
                        <textarea
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-50"
                            id="alamatUsaha" rows="2" readonly></textarea>
                        <p class="text-xs text-gray-500 mt-1">Alamat otomatis terisi</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Hasil Profiling SBR25 <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            id="profiling_sbr25" readonly>
                        <p class="text-xs text-gray-500 mt-1">Profiling otomatis terisi</p>
                    </div>

                </div>
            </div>

            <!-- Hasil Cek Lapangan Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="bg-primary text-white px-4 py-3">
                    <h2 class="font-bold text-sm">Hasil Cek Lapangan</h2>
                </div>
                <div class="p-4 space-y-4">
                    <!-- Keberadaan Usaha -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Keberadaan Usaha <span class="text-red-500">*</span>
                        </label>
                        <select id="keberadaan" name="status_usaha"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-white"
                            required>
                            <option value="">Pilih Status</option>
                            <option value="tidak_ditemukan">Tidak Ditemukan</option>
                            <option value="ditemukan">Ditemukan</option>
                            <option value="tutup">Tutup</option>
                            <option value="ganda">Ganda</option>
                        </select>

                    </div>

                    <!-- Input Alamat Baru -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat (Hasil Cek) <span
                                class="text-red-500">*</span></label>
                        <textarea
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-white"
                            id="alamatBaru" name="alamat" rows="2" placeholder="Masukkan alamat sesuai hasil cek lapangan" required></textarea>
                    </div>

                    <!-- RT dan RW -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">RW/Dusun <span
                                    class="text-red-500">*</span></label>
                            <input type="text"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                id="rw" name="rw" placeholder="Contoh: 001" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">RT <span
                                    class="text-red-500">*</span></label>
                            <input type="text"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                id="rt" name="rt" placeholder="Contoh: 002" required>
                        </div>
                    </div>

                    <!-- Input Foto -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Foto Usaha
                        </label>

                        <!-- Input File Hidden -->
                        <input type="file" id="foto" name="photo" class="hidden" accept="image/*"
                            capture="environment">

                        <!-- Tombol Kamera -->
                        <button type="button" onclick="document.getElementById('foto').click()"
                            class="w-full py-3 border-2 border-dashed border-primary rounded-lg bg-orange-50 hover:bg-orange-100 transition-colors duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <i class="fas fa-camera text-primary"></i>
                                <span class="text-sm font-medium text-primary">Ambil Foto dengan Kamera</span>
                            </div>
                        </button>
                        <p class="text-xs text-gray-500 mt-1 text-center">Klik tombol di atas untuk membuka kamera</p>

                        <!-- Preview Foto -->
                        <div class="mt-3 flex justify-center">
                            <img id="previewFoto"
                                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='150' viewBox='0 0 200 150'%3E%3Crect width='200' height='150' fill='%23f3f4f6'/%3E%3Ccircle cx='100' cy='60' r='20' fill='%23d1d5db'/%3E%3Crect x='70' y='90' width='60' height='40' rx='5' fill='%23d1d5db'/%3E%3Ctext x='100' y='140' font-family='Arial' font-size='12' text-anchor='middle' fill='%236b7280'%3EKamera%3C/text%3E%3C/svg%3E"
                                alt="Preview Foto"
                                class="rounded-lg border border-gray-300 max-w-full h-auto max-h-48 object-cover">
                        </div>
                    </div>

                    <!-- Koordinat -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Koordinat
                        </label>

                        <div class="space-y-2">
                            <!-- Latitude -->
                            <div class="flex gap-2">
                                <input type="text"
                                    class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    id="latitude" name="latitude" placeholder="Latitude">
                                <button type="button" id="btnGetLocation"
                                    class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200 flex items-center space-x-1">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Ambil</span>
                                </button>
                            </div>

                            <!-- Longitude -->
                            <div class="flex gap-2">
                                <input type="text"
                                    class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    id="longitude" name="longitude" placeholder="Longitude">
                                <button type="button" id="btnGetLocation2"
                                    class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200 flex items-center space-x-1">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Ambil</span>
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Gunakan tombol "Ambil" untuk lokasi otomatis</p>
                    </div>

                    <!-- Nama Petugas -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Nama Petugas <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            id="petugas" name="nama_petugas" placeholder="Masukkan nama petugas" required>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex gap-3 mt-6">
                <button type="reset"
                    class="flex-1 py-3 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg font-medium text-sm transition-colors duration-200 shadow-sm">
                    Reset Form
                </button>
                <button type="submit"
                    class="flex-1 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg font-medium text-sm transition-colors duration-200">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>

    <!-- Notification Alert Container -->
    <div id="alertContainer" class="fixed top-4 right-4 z-50 max-w-sm w-full"></div>

    <script>
        // JavaScript untuk form
        document.addEventListener('DOMContentLoaded', function() {
            // Handle foto
            document.getElementById('foto').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('previewFoto').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    showAlert('Foto berhasil diambil!', 'success');
                }
            });

            // Geolocation
            function getCurrentLocation(targetField) {
                if (navigator.geolocation) {
                    const button = document.getElementById(targetField === 'latitude' ? 'btnGetLocation' :
                        'btnGetLocation2');
                    const originalText = button.innerHTML;

                    button.innerHTML = '<div class="flex items-center space-x-1"><span>Loading...</span></div>';
                    button.disabled = true;

                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            document.getElementById('latitude').value = position.coords.latitude.toFixed(6);
                            document.getElementById('longitude').value = position.coords.longitude.toFixed(6);

                            button.innerHTML = originalText;
                            button.disabled = false;
                            showAlert('Lokasi berhasil diambil!', 'success');
                        },
                        function() {
                            button.innerHTML = originalText;
                            button.disabled = false;
                            showAlert('Gagal mengambil lokasi', 'error');
                        }
                    );
                }
            }

            document.getElementById('btnGetLocation').addEventListener('click', () => getCurrentLocation(
                'latitude'));
            document.getElementById('btnGetLocation2').addEventListener('click', () => getCurrentLocation(
                'longitude'));

            // Form submission
            document.getElementById('mangcekForm').addEventListener('submit', function(e) {

                let isValid = true;
                document.querySelectorAll('[required]').forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500');
                        isValid = false;
                    }
                });

                if (isValid) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Menyimpan...';

                    setTimeout(() => {
                        showAlert('Data berhasil disimpan!', 'success');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Simpan Data';
                        this.reset();
                        document.getElementById('previewFoto').src =
                            "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='150' viewBox='0 0 200 150'%3E%3Crect width='200' height='150' fill='%23f3f4f6'/%3E%3Ccircle cx='100' cy='60' r='20' fill='%23d1d5db'/%3E%3Crect x='70' y='90' width='60' height='40' rx='5' fill='%23d1d5db'/%3E%3Ctext x='100' y='140' font-family='Arial' font-size='12' text-anchor='middle' fill='%236b7280'%3EKamera%3C/text%3E%3C/svg%3E";
                    }, 1000);
                } else {
                    showAlert('Harap lengkapi semua field yang wajib diisi!', 'error');
                }
            });

            // Alert function
            function showAlert(message, type) {
                const alertContainer = document.getElementById('alertContainer');
                const alertDiv = document.createElement('div');
                const bgColor = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' :
                    'bg-red-100 border-red-400 text-red-700';

                alertDiv.className = `p-4 mb-3 rounded-lg border ${bgColor}`;
                alertDiv.innerHTML = `
            <div class="flex justify-between items-center">
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="text-gray-500">&times;</button>
            </div>
        `;

                alertContainer.appendChild(alertDiv);
                setTimeout(() => alertDiv.remove(), 5000);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            fetch('/api/kecamatan')
                .then(res => res.json())
                .then(data => {
                    const kecamatan = document.getElementById('kecamatan');
                    data.forEach(kec => {
                        kecamatan.innerHTML += `
                    <option value="${kec.kode_kecamatan}">
                        ${kec.nama_kecamatan}
                    </option>`;
                    });
                });

            document.getElementById('kecamatan').addEventListener('change', function() {
                fetch(`/api/desa/${this.value}`)
                    .then(res => res.json())
                    .then(data => {
                        const desa = document.getElementById('desa');
                        desa.innerHTML = '<option value="">Pilih Desa</option>';
                        data.forEach(d => {
                            desa.innerHTML += `
                        <option value="${d.kode_desa}">
                            ${d.nama_desa}
                        </option>`;
                        });
                    });
            });

            const searchInput = document.getElementById('usahaSearch');
            const resultBox = document.getElementById('usahaResult');

            searchInput.addEventListener('input', function() {
                if (this.value.length < 2) {
                    resultBox.classList.add('hidden');
                    return;
                }

                const desa = document.getElementById('desa').value;

                if (!desa) {
                    resultBox.classList.add('hidden');
                    return;
                }

                fetch(`/api/usaha/search?q=${this.value}&kode_desa=${desa}`)
                    .then(res => res.json())
                    .then(data => {
                        resultBox.innerHTML = '';
                        data.forEach(u => {
                            resultBox.innerHTML += `
                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer"
                            data-kode="${u.kode_nama_usaha}">
                            ${u.nama_usaha}
                        </li>`;
                        });
                        resultBox.classList.remove('hidden');
                    });
            });

            resultBox.addEventListener('click', function(e) {
                if (e.target.tagName === 'LI') {
                    const kode = e.target.dataset.kode;
                    searchInput.value = e.target.innerText;
                    document.getElementById('kode_usaha').value = kode;
                    resultBox.classList.add('hidden');

                    fetch(`/api/usaha/${kode}`)
                        .then(res => res.json())
                        .then(u => {
                            document.getElementById('alamatUsaha').value = u.alamat ?? '';
                            document.getElementById('profiling_sbr25').value = u.status_profiling_sbr ??
                                '';
                        });
                }
            });

        });
    </script>

@endsection
