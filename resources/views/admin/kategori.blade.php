<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Manajemen Kategori | SIPASSA Admin</title>
    
    <!-- Tailwind CSS + Font Awesome + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 50%, #fde68a 100%); min-height: 100vh; }
        
        .gradient-text {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -12px rgba(245,158,11,0.3);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(245,158,11,0.5);
        }
        
        .modal-backdrop { backdrop-filter: blur(8px); }
        @keyframes modalPop {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        .modal-pop { animation: modalPop 0.2s ease-out; }
        
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
                <div class="bg-white/20 p-2 rounded-xl">
                    <i class="fas fa-school text-2xl"></i>
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
                <a href="/dashboard-admin" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition mt-1">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="/admin/statistik" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition mt-1">
                    <i class="fas fa-chart-line w-5"></i>
                    <span>Statistik</span>
                </a>
                <a href="/admin/kategori" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/20 transition mt-1">
                    <i class="fas fa-tags w-5"></i>
                    <span>Manajemen Kategori</span>
                </a>
            </div>
            
            <div class="mb-6">
                <p class="text-white/70 text-xs uppercase tracking-wider mb-3">Laporan</p>
                <a href="/dashboard-admin" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition mt-1">
                    <i class="fas fa-clipboard-list w-5"></i>
                    <span>Semua Laporan</span>
                </a>
            </div>
        </nav>
        
        <div class="absolute bottom-0 w-72 p-4 border-t border-white/20">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-white/20 p-2 rounded-full">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-sm">{{ $admin->nama_admin ?? $admin->username ?? 'Admin' }}</p>
                    <p class="text-xs text-white/70">Administrator</p>
                </div>
            </div>
            <a href="/logout-admin" onclick="return confirm('Yakin ingin logout?')" class="flex items-center justify-center gap-2 w-full bg-red-500/20 hover:bg-red-500/30 text-white py-2 rounded-xl transition">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>
    
    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-y-auto p-6">
        
        <!-- HEADER -->
        <div class="mb-8" data-aos="fade-down">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold gradient-text">Manajemen Kategori</h1>
                    <p class="text-gray-600 mt-1">Kelola kategori pengaduan sarana sekolah</p>
                </div>
                <button onclick="openTambahModal()" class="btn-primary text-white px-5 py-2 rounded-xl font-semibold shadow-lg">
                    <i class="fas fa-plus mr-2"></i> Tambah Kategori
                </button>
            </div>
        </div>
        
        <!-- STATISTIK KATEGORI -->
        @php
            $totalKategori = count($kategori);
            $kategoriDigunakan = 0;
            foreach($kategori as $k) {
                $cek = App\Models\InputAspirasi::where('id_kategori', $k->id_kategori)->exists();
                if($cek) $kategoriDigunakan++;
            }
        @endphp
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="bg-white rounded-2xl p-5 shadow-lg stat-card" data-aos="fade-up" data-aos-delay="0">
                <div class="flex justify-between items-start">
                    <div><p class="text-gray-500 text-sm">Total Kategori</p><p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalKategori }}</p></div>
                    <div class="bg-amber-100 p-3 rounded-xl"><i class="fas fa-tags text-amber-600 text-xl"></i></div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-lg stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="flex justify-between items-start">
                    <div><p class="text-gray-500 text-sm">Kategori Terpakai</p><p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $kategoriDigunakan }}</p></div>
                    <div class="bg-green-100 p-3 rounded-xl"><i class="fas fa-check-circle text-green-600 text-xl"></i></div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-lg stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="flex justify-between items-start">
                    <div><p class="text-gray-500 text-sm">Kategori Tidak Terpakai</p><p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalKategori - $kategoriDigunakan }}</p></div>
                    <div class="bg-gray-100 p-3 rounded-xl"><i class="fas fa-trash-alt text-gray-600 text-xl"></i></div>
                </div>
            </div>
        </div>
        
        <!-- DAFTAR KATEGORI (CARD VIEW) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-up">
            @foreach ($kategori as $k)
            @php
                $jumlahPenggunaan = App\Models\InputAspirasi::where('id_kategori', $k->id_kategori)->count();
            @endphp
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 text-white">
                    <div class="flex justify-between items-center">
                        <i class="fas fa-folder-open text-xl"></i>
                        <div class="flex gap-2">
                            <button onclick="openEditModal('{{ $k->id_kategori }}', '{{ $k->ket_kategori }}')" class="text-white/80 hover:text-white">
                                <i class="fas fa-edit"></i>
                            </button>
                            @if($jumlahPenggunaan == 0)
                            <a href="/hapus-kategori/{{ $k->id_kategori }}" onclick="return confirm('Yakin hapus kategori {{ $k->ket_kategori }}?')" class="text-white/80 hover:text-white">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $k->ket_kategori }}</h3>
                    <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clipboard-list text-amber-500"></i>
                            <span class="text-sm text-gray-600">{{ $jumlahPenggunaan }} laporan</span>
                        </div>
                        @if($jumlahPenggunaan > 0)
                        <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">
                            <i class="fas fa-info-circle"></i> Sedang digunakan
                        </span>
                        @else
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded-full">
                            <i class="fas fa-trash"></i> Dapat dihapus
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if(count($kategori) == 0)
        <div class="text-center py-12 bg-white rounded-2xl" data-aos="fade-up">
            <i class="fas fa-folder-open text-5xl text-gray-300 mb-3"></i>
            <p class="text-gray-400">Belum ada kategori. Silakan tambah kategori terlebih dahulu.</p>
        </div>
        @endif
        
    </main>
</div>

<!-- MODAL TAMBAH KATEGORI -->
<div id="tambahModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
    <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6 modal-pop">
        <div class="flex justify-between items-center mb-4 border-b pb-3">
            <h3 class="text-xl font-bold gradient-text"><i class="fas fa-plus-circle mr-2"></i>Tambah Kategori</h3>
            <button onclick="closeTambahModal()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
        </div>
        <form action="/tambah-kategori" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori</label>
                <input type="text" name="ket_kategori" placeholder="Contoh: Kerusakan AC, Kerusakan Kursi, dll" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500" required>
            </div>
            <button type="submit" class="w-full btn-primary text-white py-2 rounded-xl font-semibold">Tambah Kategori</button>
        </form>
    </div>
</div>

<!-- MODAL EDIT KATEGORI -->
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
    <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6 modal-pop">
        <div class="flex justify-between items-center mb-4 border-b pb-3">
            <h3 class="text-xl font-bold gradient-text"><i class="fas fa-edit mr-2"></i>Edit Kategori</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori</label>
                <input type="text" id="editKategoriName" name="ket_kategori" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500" required>
            </div>
            <button type="submit" class="w-full btn-primary text-white py-2 rounded-xl font-semibold">Simpan Perubahan</button>
        </form>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 600 });
    
    function openTambahModal() {
        document.getElementById('tambahModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    function closeTambahModal() {
        document.getElementById('tambahModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    function openEditModal(id, name) {
        document.getElementById('editKategoriName').value = name;
        document.getElementById('editForm').action = '/edit-kategori/' + id;
        document.getElementById('editModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    window.onclick = function(e) {
        if(e.target === document.getElementById('tambahModal')) closeTambahModal();
        if(e.target === document.getElementById('editModal')) closeEditModal();
    }
</script>

@if(session('error'))
<div class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
    <i class="fas fa-exclamation-circle"></i>
    <span>{{ session('error') }}</span>
    <button onclick="this.parentElement.remove()" class="ml-3"><i class="fas fa-times"></i></button>
</div>
@endif

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="ml-3"><i class="fas fa-times"></i></button>
</div>
@endif
</body>
</html>