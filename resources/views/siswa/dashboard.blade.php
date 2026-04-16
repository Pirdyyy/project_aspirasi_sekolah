<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Dashboard Siswa | SIPASSA SMK N 7 Batam</title>
    
    <!-- Tailwind CSS + Font Awesome + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 50%, #fde68a 100%); min-height: 100vh; }
        
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
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        .modal-backdrop {
            backdrop-filter: blur(8px);
        }
        
        @keyframes modalPop {
            from { opacity: 0; transform: scale(0.9) translateY(-20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .modal-pop {
            animation: modalPop 0.3s ease-out;
        }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #fef3c7; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #f59e0b; border-radius: 10px; }
        
        .preview-image {
            max-width: 100%;
            max-height: 200px;
            border-radius: 10px;
            object-fit: cover;
        }
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
                    <p class="text-xs text-white/80">Siswa Panel</p>
                </div>
            </div>
        </div>
        
        <nav class="p-4">
            <div class="mb-6">
                <p class="text-white/70 text-xs uppercase tracking-wider mb-3">Menu Utama</p>
                <a href="/dashboard-siswa" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/20 transition">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="/input-aspirasi" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition mt-1">
                    <i class="fas fa-plus-circle w-5"></i>
                    <span>Buat Laporan</span>
                </a>
            </div>
        </nav>
        
        <div class="absolute bottom-0 w-72 p-4 border-t border-white/20">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-white/20 p-2 rounded-full">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-sm truncate">{{ $siswa->nama ?? 'Siswa' }}</p>
                    <p class="text-xs text-white/70">Kelas: {{ $siswa->kelas ?? '-' }}</p>
                </div>
            </div>
            <a href="/logout-siswa" onclick="return confirm('Yakin logout?')" class="flex items-center justify-center gap-2 w-full bg-red-500/20 hover:bg-red-500/30 text-white py-2 rounded-xl transition">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>
    
    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-y-auto p-6">
        
        <!-- HEADER -->
        <div class="mb-8">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard Siswa</h1>
                    <p class="text-gray-600 mt-1">Selamat datang, <span class="font-semibold text-amber-600">{{ $siswa->nama ?? 'Siswa' }}</span>! 👋</p>
                </div>
                <a href="/input-aspirasi" class="btn-primary text-white px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 shadow-md">
                    <i class="fas fa-plus-circle"></i> Buat Laporan Baru
                </a>
            </div>
        </div>
        
        @php
            $totalLaporan = count($data);
            $selesai = 0;
            $proses = 0;
            $pending = 0;
            
            foreach($data as $d) {
                $status = $d->aspirasi->status ?? 'Belum diproses';
                if ($status == 'Selesai') $selesai++;
                elseif ($status == 'Dalam Proses') $proses++;
                else $pending++;
            }
            $progressPercent = $totalLaporan > 0 ? round(($selesai / $totalLaporan) * 100) : 0;
        @endphp
        
        <!-- STATISTIK CARD -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-2xl p-5 shadow-lg border-l-8 border-l-amber-500 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Total Laporan</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalLaporan }}</p>
                    </div>
                    <div class="bg-amber-100 p-3 rounded-xl">
                        <i class="fas fa-clipboard-list text-amber-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-lg border-l-8 border-l-blue-500 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Diproses</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $proses }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-xl">
                        <i class="fas fa-spinner fa-pulse text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-lg border-l-8 border-l-green-500 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Selesai</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $selesai }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-xl">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-lg border-l-8 border-l-purple-500 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Menunggu</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $pending }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-xl">
                        <i class="fas fa-clock text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- PROGRESS CARD -->
        <div class="bg-white rounded-2xl shadow-lg p-5 mb-8">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-chart-line text-amber-500"></i> Progress Laporan Anda
                </h3>
                <span class="text-sm font-bold text-amber-600">{{ $progressPercent }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-amber-500 h-3 rounded-full transition-all" style="width: {{ $progressPercent }}%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-2">{{ $selesai }} dari {{ $totalLaporan }} laporan telah selesai</p>
        </div>
        
        <!-- DAFTAR LAPORAN -->
        <div class="mb-4 flex justify-between items-center flex-wrap gap-3">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-list-ul text-amber-500"></i> Riwayat Laporan Saya
            </h2>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="searchInput" placeholder="Cari laporan..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm w-64 focus:ring-2 focus:ring-amber-500">
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="laporanContainer">
            @forelse($data as $d)
            @php
                $statusText = $d->aspirasi->status ?? 'Belum diproses';
                $feedbackText = $d->aspirasi->feedback ?? 'Belum ada feedback';
                $kategoriNama = $d->kategori->ket_kategori ?? 'Umum';
                
                $badgeClass = 'bg-gray-100 text-gray-700';
                $statusIcon = 'fa-hourglass-half';
                if($statusText == 'Selesai') {
                    $badgeClass = 'bg-green-100 text-green-700';
                    $statusIcon = 'fa-check-circle';
                } elseif($statusText == 'Dalam Proses') {
                    $badgeClass = 'bg-blue-100 text-blue-700';
                    $statusIcon = 'fa-spinner fa-pulse';
                } elseif($statusText == 'Menunggu Proses') {
                    $badgeClass = 'bg-yellow-100 text-yellow-700';
                    $statusIcon = 'fa-clock';
                }
            @endphp
            <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border border-gray-100 laporan-card" data-search="{{ $kategoriNama }} {{ $d->lokasi }}">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 text-white">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-file-alt"></i>
                            <span class="font-semibold text-sm">Laporan #{{ $d->id_pelaporan }}</span>
                        </div>
                        <span class="status-badge {{ $badgeClass }} text-xs">
                            <i class="fas {{ $statusIcon }}"></i> {{ $statusText }}
                        </span>
                    </div>
                </div>
                
                <!-- Body Card -->
                <div class="p-4">
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <p class="text-xs text-gray-400 flex items-center gap-1">
                                <i class="fas fa-tag text-amber-500"></i> Kategori
                            </p>
                            <p class="text-sm font-medium text-gray-700">{{ $kategoriNama }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 flex items-center gap-1">
                                <i class="fas fa-location-dot text-amber-500"></i> Lokasi
                            </p>
                            <p class="text-sm font-medium text-gray-700">{{ $d->lokasi }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-xs text-gray-400 flex items-center gap-1">
                            <i class="fas fa-align-left text-amber-500"></i> Keterangan
                        </p>
                        <p class="text-sm text-gray-600 bg-gray-50 p-2 rounded-lg">{{ Str::limit($d->ket, 100) }}</p>
                    </div>
                    
                    <!-- FOTO LAPORAN (YANG DIKIRIM SISWA) -->
                    <div class="mb-3">
                        <p class="text-xs text-gray-400 flex items-center gap-1">
                            <i class="fas fa-image text-amber-500"></i> Foto Laporan
                        </p>
                        @if($d->foto && file_exists(public_path($d->foto)))
                            <div class="mt-1">
                                <img src="{{ asset($d->foto) }}" alt="Foto Kerusakan" 
                                     class="w-32 h-32 object-cover rounded-lg shadow-sm cursor-pointer hover:opacity-80 transition"
                                     onclick="openImageModal('{{ asset($d->foto) }}')">
                                <p class="text-xs text-blue-500 mt-1 cursor-pointer" onclick="openImageModal('{{ asset($d->foto) }}')">
                                    <i class="fas fa-search-plus"></i> Klik untuk memperbesar
                                </p>
                            </div>
                        @else
                            <p class="text-gray-400 italic text-sm bg-gray-50 p-2 rounded-lg">
                                <i class="fas fa-camera-slash mr-1"></i> Tidak ada foto
                            </p>
                        @endif
                    </div>
                    
                    <!-- FEEDBACK ADMIN -->
                    <div class="mb-3">
                        <p class="text-xs text-gray-400 flex items-center gap-1">
                            <i class="fas fa-comment-dots text-amber-500"></i> Feedback Admin
                        </p>
                        <div class="bg-blue-50 p-2 rounded-lg">
                            @if($feedbackText != 'Belum ada feedback')
                                <p class="text-sm text-gray-700">{{ $feedbackText }}</p>
                                <p class="text-xs text-blue-500 mt-1 flex items-center gap-1">
                                    <i class="fas fa-check-circle"></i> Sudah ditanggapi
                                </p>
                            @else
                                <p class="text-sm text-gray-400 italic">{{ $feedbackText }}</p>
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                    <i class="fas fa-clock"></i> Menunggu tanggapan admin
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- TOMBOL HAPUS -->
                    <div class="flex gap-2 mt-3 pt-3 border-t border-gray-100">
                        <a href="/hapus-aspirasi/{{ $d->id_pelaporan }}" 
                           onclick="return confirm('Yakin ingin menghapus laporan ini? Tindakan ini tidak dapat dibatalkan.')" 
                           class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg text-sm font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-trash-alt"></i> Hapus Laporan
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center py-12 bg-white rounded-xl">
                <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                <p class="text-gray-400 text-lg">Belum ada laporan</p>
                <p class="text-gray-400 text-sm mt-1">Silakan buat laporan kerusakan pertama Anda</p>
                <a href="/input-aspirasi" class="btn-primary text-white px-5 py-2 rounded-lg inline-flex items-center gap-2 mt-4">
                    <i class="fas fa-plus-circle"></i> Buat Laporan
                </a>
            </div>
            @endforelse
        </div>
        
    </main>
</div>

<!-- ==================== MODAL ZOOM FOTO ==================== -->
<div id="imageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 modal-backdrop hidden" onclick="closeImageModal()">
    <div class="relative max-w-4xl w-full mx-4" onclick="event.stopPropagation()">
        <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white text-2xl hover:text-gray-300">
            <i class="fas fa-times-circle"></i>
        </button>
        <img id="modalImage" src="" alt="Foto Laporan" class="w-full rounded-xl shadow-2xl">
    </div>
</div>

<script>
    // Search Filter
    const searchInput = document.getElementById('searchInput');
    const laporanCards = document.querySelectorAll('.laporan-card');
    
    if(searchInput) {
        searchInput.addEventListener('keyup', function() {
            const keyword = this.value.toLowerCase();
            laporanCards.forEach(card => {
                const searchText = card.getAttribute('data-search').toLowerCase();
                card.style.display = searchText.includes(keyword) ? '' : 'none';
            });
        });
    }
    
    // Image Modal Functions
    function openImageModal(imageUrl) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
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