@extends('layouts.app')

@section('title', 'MANGCEK - Mitra Bantu Ground CEK')

@section('content')
<div class="container-fluid px-2 mt-1">
    <!-- Judul Web -->
    <div class="text-center mb-3 pt-2">
        <h2 class="text-warning fw-bold">MANGCEK SE2026</h2>
        <p class="text-muted small">(Mitra Bantu Ground CEK)</p>
    </div>

    <!-- Form Utama -->
    <form id="mangcekForm" class="pb-4">
        <!-- Subcard: Data Pencarian -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-warning text-white py-2 px-3">
                <h6 class="mb-0 fw-bold">Data Hasil SBR 2025</h6>
            </div>
            <div class="card-body px-3 py-3">
                <!-- Input Kecamatan -->
                <div class="mb-3">
                    <label for="kecamatan" class="form-label small fw-bold">Kecamatan <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm" id="kecamatan" required>
                        <option value="" selected disabled>Pilih Kecamatan</option>
                        <option value="kec1">Kecamatan A</option>
                        <option value="kec2">Kecamatan B</option>
                        <option value="kec3">Kecamatan C</option>
                        <option value="kec4">Kecamatan D</option>
                    </select>
                </div>

                <!-- Input Desa/Kelurahan -->
                <div class="mb-3">
                    <label for="desa" class="form-label small fw-bold">Desa/Kelurahan <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm" id="desa" required>
                        <option value="" selected disabled>Pilih Desa/Kelurahan</option>
                        <option value="desa1">Desa/Kelurahan 1</option>
                        <option value="desa2">Desa/Kelurahan 2</option>
                        <option value="desa3">Desa/Kelurahan 3</option>
                        <option value="desa4">Desa/Kelurahan 4</option>
                    </select>
                </div>

                <!-- Input Nama Usaha -->
                <div class="mb-3">
                    <label for="usaha" class="form-label small fw-bold">Nama Usaha <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm" id="usaha" required>
                        <option value="" selected disabled>Pilih Nama Usaha</option>
                        <option value="usaha1">Toko Sembako Maju Jaya</option>
                        <option value="usaha2">Warung Makan Sederhana</option>
                        <option value="usaha3">Bengkel Motor Sejahtera</option>
                        <option value="usaha4">Salon Cantik</option>
                    </select>
                </div>

                <!-- Input Alamat -->
                <div class="mb-2">
                    <label for="alamatUsaha" class="form-label small fw-bold">Alamat Usaha</label>
                    <textarea class="form-control form-control-sm" id="alamatUsaha" rows="2" readonly style="font-size: 0.875rem;"></textarea>
                    <div class="form-text small">Alamat otomatis terisi</div>
                </div>
            </div>
        </div>

        <!-- Subcard: Hasil Cek Lapangan -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-warning text-white py-2 px-3">
                <h6 class="mb-0 fw-bold">Hasil Cek Lapangan</h6>
            </div>
            <div class="card-body px-3 py-3">
                <!-- Keberadaan Usaha -->
                <div class="mb-3">
                    <label for="keberadaan" class="form-label small fw-bold">Keberadaan Usaha <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm" id="keberadaan" required>
                        <option value="" selected disabled>Pilih Status Keberadaan</option>
                        <option value="ada">Ada</option>
                        <option value="tidak_ada">Tidak Ada</option>
                        <option value="pindah">Pindah Lokasi</option>
                        <option value="tutup">Tutup Sementara</option>
                    </select>
                </div>

                <!-- Input Alamat Baru -->
                <div class="mb-3">
                    <label for="alamatBaru" class="form-label small fw-bold">Alamat (Hasil Cek)</label>
                    <textarea class="form-control form-control-sm" id="alamatBaru" rows="2" placeholder="Masukkan alamat sesuai hasil cek lapangan" style="font-size: 0.875rem;"></textarea>
                </div>

                <!-- RT dan RW -->
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label for="rt" class="form-label small fw-bold">RT/Dusun</label>
                        <input type="text" class="form-control form-control-sm" id="rt" placeholder="Contoh: 001">
                    </div>
                    <div class="col-6">
                        <label for="rw" class="form-label small fw-bold">RW</label>
                        <input type="text" class="form-control form-control-sm" id="rw" placeholder="Contoh: 002">
                    </div>
                </div>

                <!-- Input Foto - Khusus Mobile Camera -->
                <div class="mb-3">
                    <label for="foto" class="form-label small fw-bold">Foto Usaha <span class="text-danger">*</span></label>
                    
                    <!-- Tombol Kamera Custom -->
                    <div class="text-center">
                        <div class="camera-button-container mb-2">
                            <input type="file" 
                                   id="foto" 
                                   class="d-none" 
                                   accept="image/*" 
                                   capture="environment">
                            <button type="button" 
                                    class="btn btn-outline-primary w-100 py-2" 
                                    onclick="document.getElementById('foto').click()">
                                <i class="bi bi-camera"></i> Ambil Foto dengan Kamera
                            </button>
                        </div>
                        <div class="form-text small">Klik tombol di atas untuk membuka kamera</div>
                        
                        <!-- Preview Foto -->
                        <div class="mt-2">
                            <img id="previewFoto" 
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='120' viewBox='0 0 150 120'%3E%3Crect width='150' height='120' fill='%23e9ecef'/%3E%3Ccircle cx='75' cy='40' r='15' fill='%23adb5bd'/%3E%3Crect x='45' y='65' width='60' height='40' rx='3' fill='%23adb5bd'/%3E%3Ctext x='75' y='115' font-family='Arial' font-size='10' text-anchor='middle' fill='%236c757d'%3EKamera%3C/text%3E%3C/svg%3E" 
                                 alt="Preview Foto" 
                                 class="img-thumbnail" 
                                 style="width: 100%; max-width: 200px; height: auto;">
                        </div>
                    </div>
                </div>

                <!-- Koordinat -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Koordinat <span class="text-danger">*</span></label>
                    <div class="row g-2 mb-2">
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="latitude" placeholder="Latitude" required>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-sm btn-outline-primary w-100" id="btnGetLocation">
                                <i class="bi bi-geo-alt"></i> Ambil
                            </button>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="longitude" placeholder="Longitude" required>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-sm btn-outline-primary w-100" id="btnGetLocation2">
                                <i class="bi bi-geo-alt"></i> Ambil
                            </button>
                        </div>
                    </div>
                    <div class="form-text small">Gunakan tombol "Ambil" untuk lokasi otomatis</div>
                </div>

                <!-- Nama Petugas -->
                <div class="mb-2">
                    <label for="petugas" class="form-label small fw-bold">Nama Petugas <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="petugas" placeholder="Masukkan nama petugas" required>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi - DIBAWAH FORM (Non-sticky) -->
        <div class="mt-4 mb-3">
            <div class="row g-2">
                <div class="col-6">
                    <button type="reset" class="btn btn-outline-secondary w-100 py-2">Reset Form</button>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary w-100 py-2">Simpan Data</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    /* Mobile First Design */
    body {
        background-color: #f8f9fa;
        padding-bottom: 20px; /* Padding kecil untuk bawah */
    }
    
    .container-fluid {
        padding-left: 8px;
        padding-right: 8px;
    }
    
    .card {
        border-radius: 8px;
        margin-bottom: 10px;
    }
    
    .card-header {
        border-radius: 8px 8px 0 0 !important;
        padding: 8px 12px;
    }
    
    .card-body {
        padding: 12px;
    }
    
    .form-label {
        margin-bottom: 4px;
    }
    
    .form-control, .form-select {
        border-radius: 6px;
        padding: 6px 10px;
    }
    
    .btn {
        border-radius: 6px;
        font-size: 0.875rem;
    }
    
    /* Camera button khusus */
    .camera-button-container .btn {
        background-color: #e3f2fd;
        border: 2px dashed #0d6efd;
        font-weight: 500;
    }
    
    .camera-button-container .btn:hover {
        background-color: #0d6efd;
        color: white;
    }
    
    /* Tombol aksi di bawah */
    .mt-4 {
        margin-top: 1.5rem !important;
    }
    
    /* Gambar preview */
    .img-thumbnail {
        border-radius: 8px;
        padding: 4px;
        border: 1px solid #dee2e6;
        background-color: white;
    }
    
    /* Hilangkan scroll horizontal */
    html, body {
        max-width: 100%;
        overflow-x: hidden;
    }
    
    /* Adjust untuk layar sangat kecil */
    @media (max-width: 360px) {
        .container-fluid {
            padding-left: 6px;
            padding-right: 6px;
        }
        
        h2 {
            font-size: 1.5rem;
        }
        
        .card-body {
            padding: 10px;
        }
        
        .btn {
            padding: 8px 12px;
        }
    }
    
    /* Adjust untuk tablet */
    @media (min-width: 768px) {
        .container-fluid {
            max-width: 500px;
            margin: 0 auto;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simulasi data alamat berdasarkan pilihan usaha
        const usahaData = {
            'usaha1': 'Jl. Merdeka No. 12, Kecamatan A',
            'usaha2': 'Jl. Sudirman No. 45, Kecamatan B',
            'usaha3': 'Jl. Pemuda No. 8, Kecamatan C',
            'usaha4': 'Jl. Diponegoro No. 33, Kecamatan D'
        };
        
        // Update alamat saat memilih usaha
        document.getElementById('usaha').addEventListener('change', function() {
            const selectedUsaha = this.value;
            document.getElementById('alamatUsaha').value = usahaData[selectedUsaha] || '';
        });
        
        // Handle input file foto
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi tipe file
                if (!file.type.match('image.*')) {
                    showAlert('Hanya file gambar yang diperbolehkan!', 'danger');
                    return;
                }
                
                // Validasi ukuran file (maks 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showAlert('Ukuran file maksimal 5MB!', 'danger');
                    return;
                }
                
                // Preview gambar
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewFoto').src = e.target.result;
                };
                reader.readAsDataURL(file);
                
                // Tampilkan notifikasi
                showAlert('Foto berhasil diambil!', 'success');
            }
        });
        
        // Ambil lokasi untuk latitude
        document.getElementById('btnGetLocation').addEventListener('click', function() {
            getCurrentLocation('latitude');
        });
        
        // Ambil lokasi untuk longitude
        document.getElementById('btnGetLocation2').addEventListener('click', function() {
            getCurrentLocation('longitude');
        });
        
        function getCurrentLocation(targetField) {
            if (navigator.geolocation) {
                // Tampilkan loading state
                const button = targetField === 'latitude' ? 
                    document.getElementById('btnGetLocation') : 
                    document.getElementById('btnGetLocation2');
                
                const originalText = button.innerHTML;
                button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengambil...';
                button.disabled = true;
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        if (targetField === 'latitude') {
                            document.getElementById('latitude').value = position.coords.latitude.toFixed(6);
                        } else {
                            document.getElementById('longitude').value = position.coords.longitude.toFixed(6);
                        }
                        
                        // Reset button
                        button.innerHTML = originalText;
                        button.disabled = false;
                        
                        // Tampilkan notifikasi sukses
                        showAlert('Lokasi berhasil diambil!', 'success');
                    },
                    function(error) {
                        let errorMessage = 'Gagal mengambil lokasi: ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Izin ditolak. Aktifkan lokasi di pengaturan browser.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Informasi lokasi tidak tersedia.';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Permintaan lokasi waktu habis.';
                                break;
                            default:
                                errorMessage += 'Terjadi kesalahan.';
                        }
                        
                        // Reset button
                        button.innerHTML = originalText;
                        button.disabled = false;
                        
                        showAlert(errorMessage, 'danger');
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                showAlert('Browser Anda tidak mendukung Geolocation', 'danger');
            }
        }
        
        // Handle form submission
        document.getElementById('mangcekForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validasi semua required fields
            const requiredFields = document.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            // Validasi khusus foto
            const fotoInput = document.getElementById('foto');
            if (!fotoInput.files || fotoInput.files.length === 0) {
                showAlert('Harap ambil foto terlebih dahulu!', 'danger');
                isValid = false;
            }
            
            if (isValid) {
                // Simulasi loading
                const submitBtn = document.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';
                submitBtn.disabled = true;
                
                // Simulasi proses penyimpanan
                setTimeout(() => {
                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    
                    // Tampilkan notifikasi sukses
                    showAlert('Data berhasil disimpan!', 'success');
                    
                    // Reset form setelah 2 detik
                    setTimeout(() => {
                        document.getElementById('mangcekForm').reset();
                        document.getElementById('previewFoto').src = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='120' viewBox='0 0 150 120'%3E%3Crect width='150' height='120' fill='%23e9ecef'/%3E%3Ccircle cx='75' cy='40' r='15' fill='%23adb5bd'/%3E%3Crect x='45' y='65' width='60' height='40' rx='3' fill='%23adb5bd'/%3E%3Ctext x='75' y='115' font-family='Arial' font-size='10' text-anchor='middle' fill='%236c757d'%3EKamera%3C/text%3E%3C/svg%3E";
                    }, 2000);
                }, 1500);
            } else {
                showAlert('Harap lengkapi semua field yang wajib diisi!', 'danger');
                
                // Scroll ke field pertama yang error
                const firstError = document.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        // Fungsi untuk menampilkan alert
        function showAlert(message, type) {
            // Hapus alert sebelumnya jika ada
            const existingAlert = document.querySelector('.alert');
            if (existingAlert) {
                existingAlert.remove();
            }
            
            // Buat alert baru
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show mx-2 mt-2 mb-3 py-2`;
            alertDiv.style.fontSize = '0.875rem';
            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle'} me-2"></i>
                    <div>${message}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="padding: 0.5rem;"></button>
                </div>
            `;
            
            // Tambahkan alert di bawah judul
            const titleDiv = document.querySelector('.text-center');
            titleDiv.parentNode.insertBefore(alertDiv, titleDiv.nextSibling);
            
            // Hilangkan alert setelah 5 detik
            setTimeout(() => {
                if (alertDiv.parentElement) {
                    alertDiv.remove();
                }
            }, 5000);
        }
        
        // Auto-focus ke field pertama
        document.getElementById('kecamatan').focus();
    });
</script>
@endsection