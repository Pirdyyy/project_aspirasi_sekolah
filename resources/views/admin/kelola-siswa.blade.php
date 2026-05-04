<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Kelola Siswa | SIPASSA Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 50%, #fde68a 100%);
            min-height: 100vh;
        }

        .gradient-text {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(245, 158, 11, 0.5);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -12px rgba(245, 158, 11, 0.3);
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #fef3c7;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #f59e0b;
            border-radius: 10px;
        }

        .modal-backdrop {
            backdrop-filter: blur(8px);
        }

        @keyframes modalPop {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-pop {
            animation: modalPop 0.2s ease-out;
        }
    </style>
</head>

<body>

    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside
            class="w-72 bg-gradient-to-b from-[#d97706] to-[#f59e0b] text-white flex-shrink-0 shadow-xl overflow-y-auto">
            <div class="p-6 border-b border-white/20">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-full bg-amber-100">
                        <img src="{{ asset('images/logo-skaju.png') }}" alt="Logo SIPASSA"
                            class="w-8 h-8 object-contain">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">SIPASSA</h1>
                        <p class="text-xs text-white/80">Admin Panel</p>
                    </div>
                </div>
            </div>
            <nav class="p-4">
                <div class="mb-6">
                    <p class="text-white/70 text-xs uppercase tracking-wider mb-3">Menu Utama</p>
                    <a href="/dashboard-admin"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">
                        <i class="fas fa-tachometer-alt w-5"></i><span>Dashboard</span>
                    </a>
                    <a href="/admin/kategori"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition mt-1">
                        <i class="fas fa-tags w-5"></i><span>Manajemen Kategori</span>
                    </a>
                    <a href="/admin/kelola-siswa"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/20 transition mt-1">
                        <i class="fas fa-users w-5"></i><span>Kelola Siswa</span>
                    </a>
                </div>
            </nav>
            <div class="absolute bottom-0 w-72 p-4 border-t border-white/20">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-white/20 p-2 rounded-full"><i class="fas fa-user-shield"></i></div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm truncate">
                            {{ $admin->nama_admin ?? ($admin->username ?? 'Admin') }}</p>
                        <p class="text-xs text-white/70">Administrator</p>
                    </div>
                </div>
                <a href="/logout-admin" onclick="return confirm('Yakin logout?')"
                    class="flex items-center justify-center gap-2 w-full bg-red-500/20 hover:bg-red-500/30 text-white py-2 rounded-xl transition">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto p-6">

            <!-- HEADER -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold gradient-text">Kelola Data Siswa</h1>
                <p class="text-gray-600">Tambah, edit, dan kelola akun siswa</p>
            </div>

            <!-- STATISTIK SINGKAT -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="bg-white rounded-2xl p-5 shadow-lg stat-card">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Total Siswa</p>
                            <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalSiswa }}</p>
                        </div>
                        <div class="bg-amber-100 p-3 rounded-xl"><i class="fas fa-users text-amber-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-lg stat-card">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Total Laporan</p>
                            <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalLaporan }}</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-xl"><i
                                class="fas fa-clipboard-list text-blue-600 text-xl"></i></div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-lg stat-card">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Siswa Aktif</p>
                            <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $siswaAktif }}</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-xl"><i
                                class="fas fa-check-circle text-green-600 text-xl"></i></div>
                    </div>
                </div>
            </div>

            <!-- FORM REGISTRASI SISWA -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-user-plus text-white text-xl"></i>
                        <h2 class="text-white text-xl font-bold">Tambah Siswa Baru</h2>
                    </div>
                </div>

                <form action="/admin/kelola-siswa/registrasi" method="POST" class="p-6" id="registrasiForm">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">NIS <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="text" name="nis" id="nisInput" value="{{ old('nis') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all"
                                    placeholder="Masukkan NIS (8 digit)" maxlength="8" oninput="validateNIS(this)">
                                <div id="nisIndicator"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-gray-300">
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <p id="nisStatus" class="text-xs text-gray-400">NIS terdiri dari 8 digit angka</p>
                                <p id="nisCounter" class="text-xs font-mono text-gray-400">0/8</p>
                            </div>
                            @error('nis')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">Nama Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500"
                                placeholder="Masukkan nama siswa">
                            @error('nama')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">Kelas <span
                                    class="text-red-500">*</span></label>
                            <select name="kelas" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500">
                                <option value="">Pilih Kelas</option>
                                <option value="X RPL 1">X RPL 1</option>
                                <option value="X RPL 2">X RPL 2</option>
                                <option value="X RPL 3">X RPL 3</option>
                                <option value="X RPL 4">X RPL 4</option>
                                <option value="XI RPL 1">XI RPL 1</option>
                                <option value="XI RPL 2">XI RPL 2</option>
                                <option value="XI RPL 3">XI RPL 3</option>
                                <option value="XI RPL 4">XI RPL 4</option>
                                <option value="XII RPL 1">XII RPL 1</option>
                                <option value="XII RPL 2">XII RPL 2</option>
                                <option value="XII RPL 3">XII RPL 3</option>
                                <option value="XII RPL 4">XII RPL 4</option>
                                <option value="X DKV 1">X DKV 1</option>
                                <option value="X DKV 2">X DKV 2</option>
                                <option value="X DKV 3">X DKV 3</option>
                                <option value="X DKV 4">X DKV 4</option>
                                <option value="XI DKV 1">XI DKV 1</option>
                                <option value="XI DKV 2">XI DKV 2</option>
                                <option value="XI DKV 3">XI DKV 3</option>
                                <option value="XI DKV 4">XI DKV 4</option>
                            </select>
                            @error('kelas')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">Password Default</label>
                            <div class="relative">
                                <input type="text" value="12345678" readonly
                                    class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-gray-50">
                                <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs">
                                    default
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" id="submitBtn"
                            class="btn-primary text-white px-6 py-2 rounded-xl font-semibold flex items-center gap-2 opacity-50 cursor-not-allowed">
                            <i class="fas fa-save"></i> Registrasi Siswa
                        </button>
                    </div>
                </form>
            </div>

            <!-- SEARCH SISWA -->
            <div class="mb-4 flex justify-between items-center flex-wrap gap-3">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-list text-amber-500"></i> Daftar Siswa Terdaftar
                    <span class="text-sm bg-gray-100 px-2 py-0.5 rounded-full">{{ $totalSiswa }} siswa</span>
                </h2>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="searchSiswa" placeholder="Cari NIS/Nama..."
                        class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm w-64 focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <!-- DAFTAR SISWA (CARD VIEW - SEPERTI KATEGORI) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($siswaList as $s)
                    @php
                        $jmlLaporan = $s->aspirasi->count();
                        $bisaDihapus = $jmlLaporan == 0;
                    @endphp
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover siswa-card"
                        data-search="{{ strtolower($s->nis . ' ' . $s->nama . ' ' . $s->kelas) }}">
                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 text-white">
                            <div class="flex justify-between items-center">
                                <i class="fas fa-user-graduate text-xl"></i>
                                <div class="flex gap-2">
                                    <button onclick="openResetModal('{{ $s->nis }}', '{{ $s->nama }}')"
                                        class="text-white/80 hover:text-white" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button
                                        onclick="openEditModal('{{ $s->nis }}', '{{ $s->nama }}', '{{ $s->kelas }}')"
                                        class="text-white/80 hover:text-white" title="Edit Kelas">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if ($bisaDihapus)
                                        <button onclick="hapusSiswa('{{ $s->nis }}', '{{ $s->nama }}')"
                                            class="text-white/80 hover:text-white" title="Hapus Siswa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <span class="text-white/40 cursor-not-allowed"
                                            title="Siswa memiliki laporan, tidak dapat dihapus">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $s->nama }}</h3>
                            <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-id-card text-amber-500"></i>
                                    <span class="text-sm text-gray-600">NIS: {{ $s->nis }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-school text-amber-500"></i>
                                    <span class="text-sm text-gray-600">{{ $s->kelas }}</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-100">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clipboard-list text-amber-500"></i>
                                    <span class="text-sm text-gray-600">{{ $jmlLaporan }} laporan</span>
                                </div>
                                <a href="/admin/siswa/{{ $s->nis }}/laporan"
                                    class="text-sm text-amber-500 hover:text-amber-600 transition">
                                    <i class="fas fa-eye"></i> Lihat Laporan
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 bg-white rounded-2xl">
                        <i class="fas fa-user-graduate text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-400">Belum ada siswa yang terdaftar</p>
                    </div>
                @endforelse
            </div>

        </main>
    </div>

    <!-- MODAL EDIT KELAS -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6 modal-pop">
            <div class="flex justify-between items-center mb-4 border-b pb-3">
                <h3 class="text-xl font-bold gradient-text"><i class="fas fa-edit mr-2"></i>Edit Kelas Siswa</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600"><i
                        class="fas fa-times text-xl"></i></button>
            </div>
            <form id="editForm" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kelas</label>
                    <select name="kelas" id="editKelas" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500"
                        readonly>
                        <option value="X RPL 1">X RPL 1</option>
                        <option value="X RPL 2">X RPL 2</option>
                        <option value="X RPL 3">X RPL 3</option>
                        <option value="X RPL 4">X RPL 4</option>
                        <option value="XI RPL 1">XI RPL 1</option>
                        <option value="XI RPL 2">XI RPL 2</option>
                        <option value="XI RPL 3">XI RPL 3</option>
                        <option value="XI RPL 4">XI RPL 4</option>
                        <option value="XII RPL 1">XII RPL 1</option>
                        <option value="XII RPL 2">XII RPL 2</option>
                        <option value="XII RPL 3">XII RPL 3</option>
                        <option value="XII RPL 4">XII RPL 4</option>
                        <option value="X DKV 1">X DKV 1</option>
                        <option value="X DKV 2">X DKV 2</option>
                        <option value="X DKV 3">X DKV 3</option>
                        <option value="X DKV 4">X DKV 4</option>
                        <option value="XI DKV 1">XI DKV 1</option>
                        <option value="XI DKV 2">XI DKV 2</option>
                        <option value="XI DKV 3">XI DKV 3</option>
                        <option value="XI DKV 4">XI DKV 4</option>
                    </select>
                </div>
                <button type="submit" class="w-full btn-primary text-white py-2 rounded-xl font-semibold">Simpan
                    Perubahan</button>
            </form>
        </div>
    </div>

    <!-- MODAL RESET PASSWORD -->
    <div id="resetModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6 modal-pop">
            <div class="text-center">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-key text-yellow-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Reset Password</h3>
                <p class="text-gray-500 text-sm mb-4">
                    Yakin ingin mereset password siswa <span id="resetSiswaNama"
                        class="font-semibold text-yellow-600"></span>?
                    <br>Password akan direset menjadi <span
                        class="font-mono bg-gray-100 px-2 py-1 rounded">12345678</span>
                </p>
                <form id="resetForm" method="POST">
                    @csrf
                    <div class="flex gap-3">
                        <button type="button" onclick="closeResetModal()"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold transition">Batal</button>
                        <button type="submit"
                            class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg font-semibold transition">Ya,
                            Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL KONFIRMASI HAPUS -->
    <div id="hapusModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6 modal-pop">
            <div class="text-center">
                <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Akun Siswa</h3>
                <p class="text-gray-500 text-sm mb-4">
                    Yakin ingin menghapus akun siswa <span id="hapusSiswaNama"
                        class="font-semibold text-red-600"></span>?
                    <br>Tindakan ini tidak dapat dibatalkan!
                </p>
                <form id="hapusForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" onclick="closeHapusModal()"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold transition">Batal</button>
                        <button type="submit"
                            class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-semibold transition">Ya,
                            Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Search filter untuk siswa
        const searchInput = document.getElementById('searchSiswa');
        const siswaCards = document.querySelectorAll('.siswa-card');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const keyword = this.value.toLowerCase();
                siswaCards.forEach(card => {
                    const searchText = card.getAttribute('data-search').toLowerCase();
                    card.style.display = searchText.includes(keyword) ? '' : 'none';
                });
            });
        }

        // Edit kelas modal
        function openEditModal(nis, kelas) {
            document.getElementById('editForm').action = '/admin/siswa/' + nis + '/edit-kelas';
            document.getElementById('editKelas').value = kelas;
            document.getElementById('editModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Reset password modal
        function openResetModal(nis, nama) {
            document.getElementById('resetSiswaNama').innerText = nama;
            document.getElementById('resetForm').action = '/admin/reset-password-siswa/' + nis;
            document.getElementById('resetModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeResetModal() {
            document.getElementById('resetModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Hapus siswa modal
        function hapusSiswa(nis, nama) {
            document.getElementById('hapusSiswaNama').innerText = nama;
            document.getElementById('hapusForm').action = '/admin/siswa/' + nis + '/hapus';
            document.getElementById('hapusModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeHapusModal() {
            document.getElementById('hapusModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal on backdrop click
        window.onclick = function(e) {
            if (e.target === document.getElementById('editModal')) closeEditModal();
            if (e.target === document.getElementById('resetModal')) closeResetModal();
            if (e.target === document.getElementById('hapusModal')) closeHapusModal();
        }

        // ============ VALIDASI NIS (MAKSIMAL 8 DIGIT) ============
        function validateNIS(input) {
            // Hanya izinkan angka
            input.value = input.value.replace(/[^0-9]/g, '');

            const nisValue = input.value;
            const nisLength = nisValue.length;
            const indicator = document.getElementById('nisIndicator');
            const counter = document.getElementById('nisCounter');
            const statusText = document.getElementById('nisStatus');
            const submitBtn = document.getElementById('submitBtn'); // <-- PERBAIKAN DI SINI

            // Update counter
            counter.innerText = nisLength + '/8';

            // Update warna indikator dan status
            if (nisLength === 8) {
                // Hijau - sudah 8 digit
                indicator.className =
                    'absolute right-3 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-green-500 shadow-sm';
                statusText.innerHTML = '<i class="fas fa-check-circle text-green-500 mr-1"></i> NIS lengkap (8 digit)';
                statusText.className = 'text-xs text-green-600';
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                submitBtn.classList.add('opacity-100', 'cursor-pointer');
            } else if (nisLength > 0 && nisLength < 8) {
                // Merah - belum 8 digit
                indicator.className =
                    'absolute right-3 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-red-500 animate-pulse';
                statusText.innerHTML =
                    '<i class="fas fa-exclamation-circle text-red-500 mr-1"></i> NIS harus 8 digit (saat ini ' + nisLength +
                    ' digit)';
                statusText.className = 'text-xs text-red-500';
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                submitBtn.classList.remove('opacity-100', 'cursor-pointer');
            } else {
                // Abu-abu - kosong
                indicator.className = 'absolute right-3 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-gray-300';
                statusText.innerHTML = 'NIS terdiri dari 8 digit angka';
                statusText.className = 'text-xs text-gray-400';
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                submitBtn.classList.remove('opacity-100', 'cursor-pointer');
            }

            // Tambahkan efek border
            if (nisLength === 8) {
                input.classList.add('border-green-500', 'ring-1', 'ring-green-200');
                input.classList.remove('border-red-500', 'ring-red-200', 'border-gray-300');
            } else if (nisLength > 0) {
                input.classList.add('border-red-500', 'ring-1', 'ring-red-200');
                input.classList.remove('border-green-500', 'ring-green-200', 'border-gray-300');
            } else {
                input.classList.remove('border-red-500', 'border-green-500', 'ring-1', 'ring-red-200', 'ring-green-200');
                input.classList.add('border-gray-300');
            }
        }
    </script>

    @if (session('success'))
        <div
            class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-3"><i class="fas fa-times"></i></button>
        </div>
    @endif

    @if (session('error'))
        <div
            class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-3"><i class="fas fa-times"></i></button>
        </div>
    @endif

</body>

</html>
