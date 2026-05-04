<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Ganti Password | SIPASSA</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 50%, #fde68a 100%); min-height: 100vh; }
        .btn-primary { background: linear-gradient(135deg, #d97706, #f59e0b); transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(245,158,11,0.5); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -12px rgba(245,158,11,0.3); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #fef3c7; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #f59e0b; border-radius: 10px; }
    </style>
</head>
<body>

<div class="flex h-screen overflow-hidden">
    <!-- SIDEBAR -->
    <aside class="w-72 bg-gradient-to-b from-[#d97706] to-[#f59e0b] text-white flex-shrink-0 shadow-xl overflow-y-auto">
        <div class="p-6 border-b border-white/20">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-full bg-amber-100">
                    <img src="{{ asset('images/logo-skaju.png') }}" alt="Logo SIPASSA" class="w-8 h-8 object-contain">
                </div>
                <div>
                    <h1 class="text-xl font-bold">SIPASSA</h1>
                    <p class="text-xs text-white/80">Siswa Panel</p>
                </div>
            </div>
        </div>

        <nav class="p-4">
            <div class="mb-6">
                <p class="text-white/70 text-xs uppercase tracking-wider mb-3">Menu Utama</p>
                <a href="/dashboard-siswa" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">
                    <i class="fas fa-tachometer-alt w-5"></i><span>Dashboard</span>
                </a>
                <a href="/siswa/ganti-password" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/20 transition mt-1">
                    <i class="fas fa-key w-5"></i><span>Ganti Password</span>
                </a>
            </div>
        </nav>

        <div class="absolute bottom-0 w-72 p-4 border-t border-white/20">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-white/20 p-2 rounded-full"><i class="fas fa-user-graduate"></i></div>
                <div class="flex-1">
                    <p class="font-semibold text-sm truncate">{{ $siswa->nama ?? 'Siswa' }}</p>
                    <p class="text-xs text-white/70">Kelas: {{ $siswa->kelas ?? '-' }}</p>
                </div>
            </div>
            <a href="/logout-siswa" onclick="return confirm('Yakin logout?')" class="flex items-center justify-center gap-2 w-full bg-red-500/20 hover:bg-red-500/30 text-white py-2 rounded-xl transition">
                <i class="fas fa-sign-out-alt"></i><span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-y-auto p-6">
        <div class="max-w-md mx-auto">
            <!-- HEADER -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Ganti Password</h1>
                <p class="text-gray-600 text-sm">Ubah password akun Anda untuk keamanan</p>
            </div>

            <!-- FORM GANTI PASSWORD -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-key text-white text-xl"></i>
                        <h2 class="text-white text-xl font-bold">Form Ganti Password</h2>
                    </div>
                </div>

                <form action="/siswa/ganti-password" method="POST" class="p-6">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2 text-sm">Password Lama</label>
                        <div class="relative">
                            <input type="password" name="password_lama" id="passwordLama" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent pr-10"
                                placeholder="Masukkan password lama Anda">
                            <button type="button" onclick="togglePassword('passwordLama', 'eyeLama')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-amber-500">
                                <i id="eyeLama" class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                        @error('password_lama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2 text-sm">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="password_baru" id="passwordBaru" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent pr-10"
                                placeholder="Masukkan password baru (minimal 4 karakter)">
                            <button type="button" onclick="togglePassword('passwordBaru', 'eyeBaru')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-amber-500">
                                <i id="eyeBaru" class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                        @error('password_baru')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2 text-sm">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" name="password_baru_confirmation" id="passwordKonfirmasi" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent pr-10"
                                placeholder="Ulangi password baru Anda">
                            <button type="button" onclick="togglePassword('passwordKonfirmasi', 'eyeKonfirmasi')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-amber-500">
                                <i id="eyeKonfirmasi" class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit" class="flex-1 btn-primary text-white py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Ganti Password
                        </button>
                        <a href="/dashboard-siswa" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2.5 rounded-xl font-semibold text-center transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- INFO -->
            <div class="mt-6 bg-blue-50 rounded-xl p-4">
                <div class="flex items-center gap-3">
                    <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                    <div>
                        <p class="text-sm text-gray-700">Tips keamanan password:</p>
                        <ul class="text-xs text-gray-500 mt-1 list-disc list-inside">
                            <li>Gunakan kombinasi huruf, angka, dan simbol</li>
                            <li>Minimal 6 karakter</li>
                            <li>Jangan gunakan password yang sama dengan akun lain</li>
                            <li>Jangan berikan password kepada siapapun</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="ml-3"><i class="fas fa-times"></i></button>
</div>
@endif

@if(session('error'))
<div class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
    <i class="fas fa-exclamation-circle"></i>
    <span>{{ session('error') }}</span>
    <button onclick="this.parentElement.remove()" class="ml-3"><i class="fas fa-times"></i></button>
</div>
@endif

</body>
</html>