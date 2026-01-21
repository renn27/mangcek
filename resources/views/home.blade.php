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


        <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 px-4 pb-2">
            <div
                class="bg-gradient-to-r from-gray-50 to-white shadow-md rounded-b-lg mb-6 py-2 px-4 border-b border-gray-200">
                <div class="flex items-center justify-between max-w-6xl mx-auto">
                    <!-- Logo Kiri -->
                    <div class="flex items-center space-x-2 flex-shrink-0">
                        <div class="bg-white p-1 rounded-lg shadow-sm border border-gray-200">
                            <img src="{{ asset('images/logo-bps.svg') }}" alt="Logo BPS" class="w-8 h-8 object-contain"
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
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg" disabled>

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
                                id="alamatUsaha" rows="2" readonly>{{ $data->alamat ?? '' }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Alamat otomatis terisi</p>
                        </div>

                        <!-- Koordinat -->
                        <div class="mt-3">
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Koordinat</label>

                            <div class="flex border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                                <!-- Latitude -->
                                <div class="flex-1 border-r border-gray-200">
                                    <div class="px-3 py-2">
                                        <p class="text-xs text-gray-500 mb-1">Latitude</p>
                                        <p id="latitude_database" class="text-sm">
                                            {{ $data->latitude ?? 'Tidak tersedia' }}</p>
                                    </div>
                                </div>

                                <!-- Longitude -->
                                <div class="flex-1">
                                    <div class="px-3 py-2">
                                        <p class="text-xs text-gray-500 mb-1">Longitude</p>
                                        <p id="longitude_database" class="text-sm">
                                            {{ $data->longitude ?? 'Tidak tersedia' }}</p>
                                    </div>
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 mt-2">Koordinat otomatis dari sistem</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                Hasil Profiling SBR25</span>
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

                        <!-- MAP -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                Tentukan Lokasi di Peta
                            </label>
                            <div id="map" class="w-full h-64 rounded-lg border border-gray-300"></div>
                            <p class="text-xs text-gray-500 mt-1">
                                Geser marker atau klik peta untuk menentukan koordinat
                            </p>
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

                            <p id="distanceInfo" class="text-xs text-gray-500 mt-1"></p>

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
            document.addEventListener('DOMContentLoaded', function() {

                /* =========================
                GLOBAL ELEMENTS
                ========================== */
                const form = document.getElementById('mangcekForm');
                const fotoInput = document.getElementById('foto');
                const previewFoto = document.getElementById('previewFoto');

                const kecamatanSelect = document.getElementById('kecamatan');
                const desaSelect = document.getElementById('desa');

                const usahaInput = document.getElementById('usahaSearch');
                const resultBox = document.getElementById('usahaResult');
                const kodeUsaha = document.getElementById('kode_usaha');

                const alamatUsaha = document.getElementById('alamatUsaha');
                const latitudeDatabase = document.getElementById('latitude_database');
                const longitudeDatabase = document.getElementById('longitude_database');
                const profilingSbr25 = document.getElementById('profiling_sbr25');

                const btnLat = document.getElementById('btnGetLocation');
                const btnLng = document.getElementById('btnGetLocation2');

                /* =========================
                FOTO PREVIEW
                ========================== */
                fotoInput.addEventListener('change', async function(e) {
                    const file = e.target.files[0];
                    if (!file || !file.type.startsWith('image/')) return;

                    const compressedFile = await compressImage(file, 500); // 500 KB

                    // Replace file di input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(compressedFile);
                    fotoInput.files = dataTransfer.files;

                    // Preview
                    previewFoto.src = URL.createObjectURL(compressedFile);

                    showAlert(
                        `Foto dikompres: ${(compressedFile.size / 1024).toFixed(0)} KB`,
                        'success'
                    );
                });

                /* =========================
                Membandingkan jarak
                ========================== */

                function getDatabaseCoords() {
                    const lat = parseFloat(latitudeDatabase.textContent);
                    const lng = parseFloat(longitudeDatabase.textContent);
                    if (isNaN(lat) || isNaN(lng)) return null; // Kalau tidak ada data
                    return {
                        lat,
                        lng
                    };
                }

                function getDistanceFromLatLonInMeters(lat1, lon1, lat2, lon2) {
                    const R = 6371000; // Radius bumi dalam meter
                    const dLat = (lat2 - lat1) * Math.PI / 180;
                    const dLon = (lon2 - lon1) * Math.PI / 180;
                    const a =
                        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                        Math.sin(dLon / 2) * Math.sin(dLon / 2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                    return R * c; // jarak dalam meter
                }



                function getCurrentLocation() {
                    if (!navigator.geolocation) {
                        showAlert('Browser tidak mendukung GPS', 'error');
                        return;
                    }

                    btnLat.disabled = true;
                    btnLng.disabled = true;

                    navigator.geolocation.getCurrentPosition(
                        pos => {
                            const lat = pos.coords.latitude;
                            const lng = pos.coords.longitude;

                            // ⛔ validasi wilayah
                            if (!oganIlirBounds.contains([lat, lng])) {
                                showAlert('Lokasi di luar Kabupaten Ogan Ilir', 'error');
                                btnLat.disabled = false;
                                btnLng.disabled = false;
                                return;
                            }

                            // ✅ update input
                            latInput.value = lat.toFixed(6);
                            lngInput.value = lng.toFixed(6);

                            // ✅ update map + marker
                            marker.setLatLng([lat, lng]);
                            map.setView([lat, lng], 17);

                            // ✅ hitung jarak ke database
                            const dbCoords = getDatabaseCoords();
                            if (dbCoords) {
                                const distance = getDistanceFromLatLonInMeters(
                                    dbCoords.lat, dbCoords.lng,
                                    lat, lng
                                );
                                distanceInfo.textContent =
                                    `Lokasi berjarak ${distance.toFixed(1)} meter dari lokasi di database.`;
                            }

                            btnLat.disabled = false;
                            btnLng.disabled = false;

                            showAlert('Lokasi berhasil diambil', 'success');
                        },
                        err => {
                            showAlert('Gagal mengambil lokasi GPS', 'error');
                            btnLat.disabled = false;
                            btnLng.disabled = false;
                        }, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                }

                btnLat.addEventListener('click', getCurrentLocation);
                btnLng.addEventListener('click', getCurrentLocation);


                /* =========================
                SUBMIT FORM
                ========================== */
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (!kodeUsaha.value) {
                        showAlert('Silakan pilih Nama Usaha dari daftar!', 'error');
                        return;
                    }

                    let valid = true;
                    this.querySelectorAll('[required]').forEach(el => {
                        if (!el.value.trim()) {
                            el.classList.add('border-red-500');
                            valid = false;
                        }
                    });

                    if (!valid) {
                        showAlert('Harap lengkapi semua field yang wajib diisi!', 'error');
                        return;
                    }

                    this.submit();
                });

                /* =========================
                       MAP LEAFLET
                    ========================== */

                const latInput = document.getElementById('latitude');
                const lngInput = document.getElementById('longitude');

                // Default lokasi (Indonesia / bisa kamu set dari database)
                const defaultLat = -2.5489;
                const defaultLng = 118.0149;

                // Batas Kabupaten Ogan Ilir
                const oganIlirBounds = L.latLngBounds(
                    [-3.60, 104.30], // Barat Daya
                    [-2.90, 104.95] // Timur Laut
                );

                const map = L.map('map', {
                    maxBounds: oganIlirBounds,
                    maxBoundsViscosity: 1.0 // tidak bisa digeser keluar
                }).setView([-3.25, 104.65], 10); // tengah Ogan Ilir


                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                // Marker draggable
                let marker = L.marker([defaultLat, defaultLng], {
                    draggable: true
                }).addTo(map);

                // Saat marker digeser
                marker.on('dragend', function(e) {
                    const pos = e.target.getLatLng();
                    latInput.value = pos.lat.toFixed(6);
                    lngInput.value = pos.lng.toFixed(6);
                });

                // Saat klik peta
                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    latInput.value = e.latlng.lat.toFixed(6);
                    lngInput.value = e.latlng.lng.toFixed(6);
                });

                /* =========================
                   INTEGRASI GPS BUTTON
                ========================== */
                function moveMarker(lat, lng) {
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 17);
                }

                /* =========================
                FETCH KECAMATAN
                ========================== */
                fetch('/api/kecamatan')
                    .then(r => r.json())
                    .then(data => {
                        data.forEach(kec => {
                            kecamatanSelect.innerHTML += `
                        <option value="${kec.kode_kecamatan}">
                            ${kec.nama_kecamatan}
                        </option>`;
                        });
                    });

                /* =========================
                FETCH DESA
                ========================== */
                kecamatanSelect.addEventListener('change', function() {
                    fetch(`/api/desa/${this.value}`)
                        .then(r => r.json())
                        .then(data => {
                            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
                            data.forEach(d => {
                                desaSelect.innerHTML += `
                            <option value="${d.kode_desa}">
                                ${d.nama_desa}
                            </option>`;
                            });
                        });

                    usahaInput.value = '';
                    usahaInput.disabled = true;
                    usahaInput.placeholder = 'Pilih Desa dulu...';
                    usahaInput.classList.add('bg-gray-100', 'cursor-not-allowed');

                    kodeUsaha.value = '';
                    alamatUsaha.value = '';
                    latitudeDatabase.textContent = '-';
                    longitudeDatabase.textContent = '-';
                    profilingSbr25.value = '';
                });

                /* =========================
                SEARCH USAHA
                ========================== */
                usahaInput.disabled = true;
                usahaInput.placeholder = 'Pilih Desa dulu...';
                usahaInput.classList.add('bg-gray-100', 'cursor-not-allowed');

                usahaInput.addEventListener('input', function() {
                    if (this.value.length < 2 || !desaSelect.value) {
                        resultBox.classList.add('hidden');
                        return;
                    }

                    fetch(`/api/usaha/search?q=${this.value}&kode_desa=${desaSelect.value}`)
                        .then(r => r.json())
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
                    if (e.target.tagName !== 'LI') return;

                    kodeUsaha.value = e.target.dataset.kode;
                    usahaInput.value = e.target.innerText;
                    resultBox.classList.add('hidden');

                    fetch(`/api/usaha/${kodeUsaha.value}`)
                        .then(r => r.json())
                        .then(u => {
                            alamatUsaha.value = u.alamat ?? '';
                            profilingSbr25.value = u.status_profiling_sbr ?? '';
                            latitudeDatabase.textContent = u.latitude ?? '-';
                            longitudeDatabase.textContent = u.longitude ?? '-';

                        });
                });

                /* =========================
                RESET SAAT DESA GANTI
                ========================== */
                desaSelect.addEventListener('change', function() {
                    usahaInput.value = '';
                    kodeUsaha.value = '';
                    resultBox.classList.add('hidden');
                    alamatUsaha.value = '';
                    latitudeDatabase.textContent = '';
                    longitudeDatabase.textContent = '';
                    profilingSbr25.value = '';

                    if (this.value) {
                        usahaInput.disabled = false;
                        usahaInput.placeholder = 'Cari Nama Usaha...';
                        usahaInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                    } else {
                        usahaInput.disabled = true;
                        usahaInput.placeholder = 'Pilih Desa dulu...';
                        usahaInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                    }
                });

            });

            function compressImage(file, maxKB) {
                return new Promise(resolve => {
                    const img = new Image();
                    const reader = new FileReader();

                    reader.onload = e => {
                        img.src = e.target.result;
                    };

                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');

                        // Resize (maks lebar 1280px)
                        const maxWidth = 1280;
                        let {
                            width,
                            height
                        } = img;

                        if (width > maxWidth) {
                            height = height * (maxWidth / width);
                            width = maxWidth;
                        }

                        canvas.width = width;
                        canvas.height = height;
                        ctx.drawImage(img, 0, 0, width, height);

                        let quality = 0.7;

                        function attemptCompress() {
                            canvas.toBlob(blob => {
                                if (blob.size / 1024 <= maxKB || quality <= 0.4) {
                                    resolve(new File([blob], file.name, {
                                        type: 'image/jpeg'
                                    }));
                                } else {
                                    quality -= 0.1;
                                    attemptCompress();
                                }
                            }, 'image/jpeg', quality);
                        }

                        attemptCompress();
                    };

                    reader.readAsDataURL(file);
                });
            }
        </script>

    @endsection
