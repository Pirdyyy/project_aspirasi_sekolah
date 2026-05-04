<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Registrasi Siswa | SIPASSA Admin</title>

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
                        <a href="/admin/kategori"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition mt-1">
                            <i class="fas fa-tags w-5"></i><span>Manajemen Kategori</span>
                        </a>
                    </a>
                    <a href="/admin/registrasi-siswa"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/20 transition mt-1">
                        <i class="fas fa-user-plus w-5"></i><span>Registrasi Siswa</span>
                    </a>
                    <a href="/admin/kelola-siswa"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition mt-1">
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
            <div class="max-w-4xl mx-auto">
                <!-- HEADER -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Registrasi Akun Siswa</h1>
                    <p class="text-gray-600 text-sm">Tambah akun siswa baru secara manual</p>
                </div>

                <!-- STATISTIK SINGKAT -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-amber-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-400 text-xs uppercase">Total Siswa</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $totalSiswa }}</p>
                            </div>
                            <i class="fas fa-users text-amber-500 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- FORM REGISTRASI SISWA -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-user-plus text-white text-xl"></i>
                            <h2 class="text-white text-xl font-bold">Form Tambah Siswa Baru</h2>
                        </div>
                    </div>

                    <form action="/admin/registrasi-siswa" method="POST" class="p-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2 text-sm">NIS <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nis" value="{{ old('nis') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                    placeholder="Masukkan NIS siswa">
                                @error('nis')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2 text-sm">Nama Lengkap <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama" value="{{ old('nama') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                    placeholder="Masukkan nama lengkap siswa">
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
                                    <option value="X RPL 1" {{ old('kelas') == 'X RPL 1' ? 'selected' : '' }}>X RPL 1
                                    </option>
                                    <option value="X RPL 2" {{ old('kelas') == 'X RPL 2' ? 'selected' : '' }}>X RPL 2
                                    </option>
                                    <option value="X RPL 3" {{ old('kelas') == 'X RPL 3' ? 'selected' : '' }}>X RPL 3
                                    </option>
                                    <option value="X RPL 4" {{ old('kelas') == 'X RPL 4' ? 'selected' : '' }}>X RPL 4
                                    </option>
                                    <option value="XI RPL 1" {{ old('kelas') == 'XI RPL 1' ? 'selected' : '' }}>XI RPL
                                        1
                                    </option>
                                    <option value="XI RPL 2" {{ old('kelas') == 'XI RPL 2' ? 'selected' : '' }}>XI RPL
                                        2
                                    </option>
                                    <option value="XI RPL 3" {{ old('kelas') == 'XI RPL 3' ? 'selected' : '' }}>XI RPL
                                        3
                                    </option>
                                    <option value="XI RPL 4" {{ old('kelas') == 'XI RPL 4' ? 'selected' : '' }}>XI RPL
                                        4
                                    </option>
                                    <option value="XII RPL 1" {{ old('kelas') == 'XII RPL 1' ? 'selected' : '' }}>XII
                                        RPL 1
                                    </option>
                                    <option value="XII RPL 2" {{ old('kelas') == 'XII RPL 2' ? 'selected' : '' }}>XII
                                        RPL 2
                                    </option>
                                    <option value="XII RPL 3" {{ old('kelas') == 'XII RPL 3' ? 'selected' : '' }}>XII
                                        RPL 3
                                    </option>
                                    <option value="XII RPL 4" {{ old('kelas') == 'XII RPL 4' ? 'selected' : '' }}>XII
                                        RPL 4
                                    </option>
                                    <option value="X DKV 1" {{ old('kelas') == 'X DKV 1' ? 'selected' : '' }}>X DKV 1
                                    </option>
                                    <option value="X DKV 2" {{ old('kelas') == 'X DKV 2' ? 'selected' : '' }}>X DKV 2
                                    </option>
                                    <option value="X DKV 3" {{ old('kelas') == 'X DKV 3' ? 'selected' : '' }}>X DKV 3
                                    </option>
                                    <option value="X DKV 4" {{ old('kelas') == 'X DKV 4' ? 'selected' : '' }}>X DKV 4
                                    </option>
                                    <option value="XI DKV 1" {{ old('kelas') == 'XI DKV 1' ? 'selected' : '' }}>XI DKV
                                        1
                                    </option>
                                    <option value="XI DKV 2" {{ old('kelas') == 'XI DKV 2' ? 'selected' : '' }}>XI DKV
                                        2
                                    </option>
                                    <option value="XI DKV 3" {{ old('kelas') == 'XI DKV 3' ? 'selected' : '' }}>XI DKV
                                        3
                                    </option>
                                    <option value="XI DKV 4" {{ old('kelas') == 'XI DKV 4' ? 'selected' : '' }}>XI DKV
                                        4
                                    </option>
                                </select>
                                @error('kelas')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2 text-sm">Password Default</label>
                                <div class="relative">
                                    <input type="text" name="password" id="password" value="12345678"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-gray-50"
                                        readonly>
                                    <button type="button" onclick="copyPassword()"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-amber-500 hover:text-amber-600">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Password default: <span
                                        class="font-mono">12345678</span> (bisa diubah nanti oleh siswa)</p>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-6">
                            <button type="submit"
                                class="flex-1 btn-primary text-white py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i> Registrasi Siswa
                            </button>
                            <a href="/dashboard-admin"
                                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2.5 rounded-xl font-semibold text-center transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>

                <!-- DAFTAR SISWA YANG SUDAH TERDAFTAR -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-users text-amber-500"></i> Daftar Siswa Terdaftar
                            <span class="text-sm bg-gray-100 px-2 py-0.5 rounded-full">{{ $totalSiswa }}
                                siswa</span>
                        </h2>
                        <div class="relative">
                            <i
                                class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" id="searchSiswa" placeholder="Cari NIS/Nama..."
                                class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm w-64 focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b">
                                    <tr class="text-left text-gray-600">
                                        <th class="px-4 py-3">No</th>
                                        <th class="px-4 py-3">NIS</th>
                                        <th class="px-4 py-3">Nama</th>
                                        <th class="px-4 py-3">Kelas</th>
                                        <th class="px-4 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100" id="siswaTableBody">
                                    @forelse($siswaList as $index => $s)
                                        @php
                                            $statusLogin = $s->last_login ? 'Sudah Login' : 'Belum Login';
                                            $statusClass = $s->last_login
                                                ? 'text-green-600 bg-green-50'
                                                : 'text-gray-500 bg-gray-50';
                                            $statusIcon = $s->last_login ? 'fa-check-circle' : 'fa-clock';
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition siswa-row"
                                            data-search="{{ strtolower($s->nis . ' ' . $s->nama . ' ' . $s->kelas) }}">
                                            <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-800">{{ $s->nis }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $s->nama }}</td>
                                            <td class="px-4 py-3 text-gray-600">{{ $s->kelas }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <button
                                                    onclick="resetPassword('{{ $s->nis }}', '{{ $s->nama }}')"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs transition"
                                                    title="Reset Password">
                                                    <i class="fas fa-key"></i> Reset
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                                <i class="fas fa-user-graduate text-4xl mb-2 block"></i>
                                                Belum ada siswa yang terdaftar
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL RESET PASSWORD -->
    <div id="resetPasswordModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6 modal-pop">
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-key text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Reset Password</h3>
                <p class="text-gray-500 text-sm mb-4">
                    Yakin ingin mereset password siswa <span id="resetSiswaNama"
                        class="font-semibold text-amber-600"></span>?
                    <br>Password akan direset menjadi <span
                        class="font-mono bg-gray-100 px-2 py-1 rounded">12345678</span>
                </p>
                <form id="resetPasswordForm" method="POST">
                    @csrf
                    <div class="flex gap-3">
                        <button type="button" onclick="closeResetModal()"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold transition">Batal</button>
                        <button type="submit"
                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg font-semibold transition">Ya,
                            Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Search siswa
        const searchInput = document.getElementById('searchSiswa');
        const siswaRows = document.querySelectorAll('.siswa-row');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const keyword = this.value.toLowerCase();
                siswaRows.forEach(row => {
                    const searchText = row.getAttribute('data-search').toLowerCase();
                    row.style.display = searchText.includes(keyword) ? '' : 'none';
                });
            });
        }

        // Copy password
        function copyPassword() {
            const passwordInput = document.getElementById('password');
            passwordInput.select();
            document.execCommand('copy');
            alert('Password default berhasil disalin!');
        }

        // Reset password
        let resetNis = '';

        function resetPassword(nis, nama) {
            resetNis = nis;
            document.getElementById('resetSiswaNama').innerText = nama;
            document.getElementById('resetPasswordForm').action = '/admin/reset-password-siswa/' + nis;
            document.getElementById('resetPasswordModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeResetModal() {
            document.getElementById('resetPasswordModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        window.onclick = function(e) {
            const modal = document.getElementById('resetPasswordModal');
            if (e.target === modal) closeResetModal();
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
