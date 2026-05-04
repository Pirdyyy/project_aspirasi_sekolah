<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Dashboard Siswa | SIPASSA SMK N 7 Batam</title>

    <!-- Tailwind CSS + Font Awesome + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 50%, #fde68a 100%);
            min-height: 100vh;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -12px rgba(245, 158, 11, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(245, 158, 11, 0.5);
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

        .filter-active {
            background-color: #f59e0b !important;
            color: white !important;
            border-color: #f59e0b !important;
        }

        .filter-inactive {
            background-color: #f3f4f6 !important;
            color: #374151 !important;
            border-color: #e5e7eb !important;
        }

        .modal-backdrop {
            backdrop-filter: blur(8px);
        }

        @keyframes modalPop {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-pop {
            animation: modalPop 0.3s ease-out;
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

        .preview-image {
            max-width: 100%;
            max-height: 200px;
            border-radius: 10px;
            object-fit: cover;
        }

        /* Tooltip styles */
        .feedback-tooltip {
            position: relative;
            cursor: help;
            display: inline-block;
            border-bottom: 1px dashed #9ca3af;
        }

        .feedback-tooltip .tooltip-text {
            visibility: hidden;
            width: 250px;
            background-color: #1f2937;
            color: #fff;
            text-align: center;
            border-radius: 8px;
            padding: 8px 12px;
            position: absolute;
            z-index: 10;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.75rem;
            font-weight: normal;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            pointer-events: none;
            white-space: nowrap;
        }

        .feedback-tooltip .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #1f2937 transparent transparent transparent;
        }

        .feedback-tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
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
                        <p class="text-xs text-white/80">Siswa Panel</p>
                    </div>
                </div>
            </div>

            <nav class="p-4">
                <div class="mb-6">
                    <p class="text-white/70 text-xs uppercase tracking-wider mb-3">Menu Utama</p>
                    <a href="/dashboard-siswa"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/20 transition">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </nav>

            <!-- Profil di Sidebar (Bisa diklik) -->
            <div onclick="openProfileModal()"
                class="absolute bottom-0 w-72 p-4 border-t border-white/20 cursor-pointer hover:bg-white/10 transition">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm truncate">{{ $siswa->nama ?? 'Siswa' }}</p>
                        <p class="text-xs text-white/70">Kelas: {{ $siswa->kelas ?? '-' }}</p>
                    </div>
                    <i class="fas fa-chevron-right text-xs text-white/50"></i>
                </div>
                <a href="/logout-siswa" onclick="return confirm('Yakin logout?')"
                    class="flex items-center justify-center gap-2 w-full bg-red-500/20 hover:bg-red-500/30 text-white py-2 rounded-xl transition">
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
                        <p class="text-gray-600 mt-1">Selamat datang, <span
                                class="font-semibold text-amber-600">{{ $siswa->nama ?? 'Siswa' }}</span>! 👋</p>
                    </div>
                    <a href="/input-aspirasi"
                        class="btn-primary text-white px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 shadow-md">
                        <i class="fas fa-plus-circle"></i> Buat Laporan Baru
                    </a>
                </div>
            </div>

            @php
                $totalLaporan = count($data);
                $selesai = 0;
                $proses = 0;
                $pending = 0;

                foreach ($data as $d) {
                    $status = $d->aspirasi->status ?? 'Belum diproses';
                    if ($status == 'Selesai') {
                        $selesai++;
                    } elseif ($status == 'Dalam Proses') {
                        $proses++;
                    } else {
                        $pending++;
                    }
                }
                $progressPercent = $totalLaporan > 0 ? round(($selesai / $totalLaporan) * 100) : 0;
            @endphp

            <!-- STATISTIK CARD (Bisa diklik untuk filter) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
                <div onclick="filterByStatus('semua')" id="filterSemua"
                    class="bg-white rounded-2xl p-5 shadow-lg border-l-8 border-l-amber-500 card-hover cursor-pointer transition hover:scale-105">
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
                <div onclick="filterByStatus('proses')" id="filterProses"
                    class="bg-white rounded-2xl p-5 shadow-lg border-l-8 border-l-blue-500 card-hover cursor-pointer transition hover:scale-105">
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
                <div onclick="filterByStatus('selesai')" id="filterSelesai"
                    class="bg-white rounded-2xl p-5 shadow-lg border-l-8 border-l-green-500 card-hover cursor-pointer transition hover:scale-105">
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
                <div onclick="filterByStatus('menunggu')" id="filterMenunggu"
                    class="bg-white rounded-2xl p-5 shadow-lg border-l-8 border-l-purple-500 card-hover cursor-pointer transition hover:scale-105">
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
                    <div class="bg-amber-500 h-3 rounded-full transition-all" style="width: {{ $progressPercent }}%">
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $selesai }} dari {{ $totalLaporan }} laporan telah
                    selesai</p>
            </div>

            <!-- FILTER STATUS BUTTON + SEARCH -->
            <div class="mb-4 flex flex-wrap justify-between items-center gap-3">
                <div class="flex flex-wrap gap-2">
                    <button onclick="filterByStatus('semua')" id="btnSemua"
                        class="filter-active px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                        <i class="fas fa-list"></i> Semua
                    </button>
                    <button onclick="filterByStatus('proses')" id="btnProses"
                        class="filter-inactive px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                        <i class="fas fa-spinner fa-pulse"></i> Dalam Proses
                    </button>
                    <button onclick="filterByStatus('selesai')" id="btnSelesai"
                        class="filter-inactive px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> Selesai
                    </button>
                    <button onclick="filterByStatus('menunggu')" id="btnMenunggu"
                        class="filter-inactive px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                        <i class="fas fa-clock"></i> Menunggu / Belum Diproses
                    </button>
                </div>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="searchInput" placeholder="Cari kategori/lokasi..."
                        class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm w-64 focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <!-- Info Filter Aktif -->
            <div id="filterInfo" class="text-xs text-gray-500 mb-3 hidden">
                <i class="fas fa-filter text-amber-500"></i> Menampilkan: <span id="filterStatusText">Semua</span>
                laporan
                <button onclick="resetFilter()" class="text-amber-500 hover:underline ml-2">
                    <i class="fas fa-times-circle"></i> Hapus filter
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="laporanContainer">
                @forelse($data as $d)
                    @php
                        $statusText = $d->aspirasi->status ?? 'Belum diproses';
                        $feedbackText = $d->aspirasi->feedback ?? 'Belum ada feedback';
                        $kategoriNama = $d->kategori->ket_kategori ?? 'Umum';
                        $feedbackTime = $d->aspirasi->updated_at ?? $d->aspirasi->created_at;
                        $formattedFeedbackTime = $feedbackTime ? date('d/m/Y H:i:s', strtotime($feedbackTime)) : '-';
                        $isProcessed = $statusText != 'Belum diproses' && $statusText != 'Menunggu Proses';
                        $bisaHapus =
                            ($statusText == 'Belum diproses' || $statusText == 'Menunggu Proses') &&
                            $feedbackText == 'Belum ada feedback';

                        $tanggalUpload = '-';
                        if ($d->created_at) {
                            $tanggalUpload = date('d/m/Y H:i', strtotime($d->created_at));
                        }

                        $badgeClass = 'bg-gray-100 text-gray-700';
                        $statusIcon = 'fa-hourglass-half';
                        if ($statusText == 'Selesai') {
                            $badgeClass = 'bg-green-100 text-green-700';
                            $statusIcon = 'fa-check-circle';
                        } elseif ($statusText == 'Dalam Proses') {
                            $badgeClass = 'bg-blue-100 text-blue-700';
                            $statusIcon = 'fa-spinner fa-pulse';
                        } elseif ($statusText == 'Menunggu Proses' || $statusText == 'Belum diproses') {
                            $badgeClass = 'bg-yellow-100 text-yellow-700';
                            $statusIcon = 'fa-clock';
                        }

                        // Status untuk filter
                        $filterStatus = 'menunggu';
                        if ($statusText == 'Selesai') {
                            $filterStatus = 'selesai';
                        } elseif ($statusText == 'Dalam Proses') {
                            $filterStatus = 'proses';
                        }
                    @endphp
                    <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border border-gray-100 laporan-card"
                        data-search="{{ strtolower($kategoriNama . ' ' . $d->lokasi) }}"
                        data-status="{{ $filterStatus }}">

                        <!-- Header Card -->
                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 text-white">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-file-alt"></i>
                                    <div>
                                        <span class="font-semibold text-sm">Laporan #{{ $d->id_pelaporan }}</span>
                                        <p class="text-xs text-white/80 mt-0.5">
                                            <i class="fas fa-calendar-alt mr-1"></i> {{ $tanggalUpload }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="status-badge {{ $badgeClass }} text-xs">
                                        <i class="fas {{ $statusIcon }}"></i> {{ $statusText }}
                                    </span>
                                    @if ($bisaHapus)
                                        <a href="/hapus-aspirasi/{{ $d->id_pelaporan }}"
                                            onclick="return confirm('Yakin ingin menghapus laporan ini? Tindakan ini tidak dapat dibatalkan!')"
                                            class="text-white/70 hover:text-red-300 transition text-sm ml-1"
                                            title="Hapus laporan">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    @else
                                        <span class="text-white/40 cursor-not-allowed text-sm ml-1"
                                            title="Laporan sudah diproses, tidak dapat dihapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </span>
                                    @endif
                                </div>
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
                                <p class="text-sm text-gray-600 bg-gray-50 p-2 rounded-lg">
                                    {{ Str::limit($d->ket, 100) }}</p>
                            </div>

                            <!-- FOTO LAPORAN -->
                            <div class="mb-3">
                                <p class="text-xs text-gray-400 flex items-center gap-1">
                                    <i class="fas fa-image text-amber-500"></i> Foto Laporan
                                </p>
                                @if ($d->foto && file_exists(public_path($d->foto)))
                                    <div class="mt-1">
                                        <img src="{{ asset($d->foto) }}" alt="Foto Kerusakan"
                                            class="w-32 h-32 object-cover rounded-lg shadow-sm cursor-pointer hover:opacity-80 transition"
                                            onclick="openImageModal('{{ asset($d->foto) }}')">
                                        <p class="text-xs text-blue-500 mt-1 cursor-pointer"
                                            onclick="openImageModal('{{ asset($d->foto) }}')">
                                            <i class="fas fa-search-plus"></i> Klik untuk memperbesar
                                        </p>
                                    </div>
                                @else
                                    <p class="text-gray-400 italic text-sm bg-gray-50 p-2 rounded-lg">
                                        <i class="fas fa-camera-slash mr-1"></i> Tidak ada foto
                                    </p>
                                @endif
                            </div>

                            <!-- FEEDBACK ADMIN dengan Tanggal & Jam -->
                            <div class="mb-3">
                                <p class="text-xs text-gray-400 flex items-center gap-1">
                                    <i class="fas fa-comment-dots text-amber-500"></i> Feedback Admin
                                </p>
                                <div class="bg-blue-50 p-2 rounded-lg">
                                    @if ($feedbackText != 'Belum ada feedback')
                                        @php
                                            $feedbackTime = null;
                                            if ($d->aspirasi) {
                                                $feedbackTime = $d->aspirasi->updated_at ?? $d->aspirasi->created_at;
                                            }
                                            $formattedFeedbackTime = $feedbackTime
                                                ? date('d/m/Y H:i:s', strtotime($feedbackTime))
                                                : '-';
                                        @endphp
                                        <div class="feedback-tooltip">
                                            <p class="text-sm text-gray-700">{{ $feedbackText }}</p>
                                            <div class="tooltip-text">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                {{ $formattedFeedbackTime }}<br>
                                                <i class="fas fa-user-check mr-1"></i> Oleh:
                                                {{ $d->aspirasi->username ?? 'Admin' }}
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <p class="text-xs text-blue-500 flex items-center gap-1">
                                                <i class="fas fa-check-circle"></i> Sudah ditanggapi
                                            </p>
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-400 italic">{{ $feedbackText }}</p>
                                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                            <i class="fas fa-clock"></i> Menunggu tanggapan admin
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12 bg-white rounded-xl">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-400 text-lg">Belum ada laporan</p>
                        <p class="text-gray-400 text-sm mt-1">Silakan buat laporan kerusakan pertama Anda</p>
                        <a href="/input-aspirasi"
                            class="btn-primary text-white px-5 py-2 rounded-lg inline-flex items-center gap-2 mt-4">
                            <i class="fas fa-plus-circle"></i> Buat Laporan
                        </a>
                    </div>
                @endforelse
            </div>

        </main>
    </div>

    <!-- ==================== MODAL PROFIL SISWA ==================== -->
    <div id="profileModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 overflow-hidden modal-pop">
            <div class="bg-gradient-to-r from-[#d97706] to-[#f59e0b] px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-2 rounded-full">
                            <i class="fas fa-user-graduate text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-white text-xl font-bold">Profil Saya</h3>
                            <p class="text-white/80 text-sm">Informasi akun Anda</p>
                        </div>
                    </div>
                    <button onclick="closeProfileModal()" class="text-white/80 hover:text-white text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                        <span class="text-gray-500 text-sm">NIS</span>
                        <span class="font-semibold text-gray-800">{{ $siswa->nis ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                        <span class="text-gray-500 text-sm">Nama Lengkap</span>
                        <span class="font-semibold text-gray-800">{{ $siswa->nama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                        <span class="text-gray-500 text-sm">Kelas</span>
                        <span class="font-semibold text-gray-800">{{ $siswa->kelas ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                        <span class="text-gray-500 text-sm">Total Laporan</span>
                        <span class="font-semibold text-amber-600">{{ $totalLaporan }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-sm">Status Akun</span>
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">
                            <i class="fas fa-check-circle"></i> Aktif
                        </span>
                    </div>
                </div>
                <div class="mt-6">
                    <button onclick="openGantiPasswordModal()"
                        class="w-full btn-primary text-white py-2 rounded-xl font-semibold flex items-center justify-center gap-2">
                        <i class="fas fa-key"></i> Ganti Password
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL GANTI PASSWORD ==================== -->
    <div id="gantiPasswordModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 overflow-hidden modal-pop">
            <div class="bg-gradient-to-r from-[#d97706] to-[#f59e0b] px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-2 rounded-full">
                            <i class="fas fa-key text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-white text-xl font-bold">Ganti Password</h3>
                            <p class="text-white/80 text-sm">Ubah password akun Anda</p>
                        </div>
                    </div>
                    <button onclick="closeGantiPasswordModal()" class="text-white/80 hover:text-white text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <form action="/siswa/ganti-password" method="POST" class="p-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm">Password Lama</label>
                    <div class="relative">
                        <input type="password" name="password_lama" id="passwordLama" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 pr-10"
                            placeholder="Masukkan password lama Anda">
                        <button type="button" onclick="togglePasswordGanti('passwordLama', 'eyeLama')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-amber-500">
                            <i id="eyeLama" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm">Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password_baru" id="passwordBaru" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 pr-10"
                            placeholder="Minimal 4 karakter">
                        <button type="button" onclick="togglePasswordGanti('passwordBaru', 'eyeBaru')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-amber-500">
                            <i id="eyeBaru" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password_baru_confirmation" id="passwordKonfirmasi" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 pr-10"
                            placeholder="Ulangi password baru Anda">
                        <button type="button" onclick="togglePasswordGanti('passwordKonfirmasi', 'eyeKonfirmasi')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-amber-500">
                            <i id="eyeKonfirmasi" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="flex-1 btn-primary text-white py-2 rounded-xl font-semibold">
                        <i class="fas fa-save"></i> Ganti Password
                    </button>
                    <button type="button" onclick="closeGantiPasswordModal()"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-xl font-semibold transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL ZOOM FOTO -->
    <div id="imageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 modal-backdrop hidden"
        onclick="closeImageModal()">
        <div class="relative max-w-4xl w-full mx-4" onclick="event.stopPropagation()">
            <button onclick="closeImageModal()"
                class="absolute -top-10 right-0 text-white text-2xl hover:text-gray-300">
                <i class="fas fa-times-circle"></i>
            </button>
            <img id="modalImage" src="" alt="Foto Laporan" class="w-full rounded-xl shadow-2xl">
        </div>
    </div>

    <script>
        let currentFilter = 'semua';

        // Fungsi filter berdasarkan status
        function filterByStatus(status) {
            currentFilter = status;
            const cards = document.querySelectorAll('.laporan-card');
            const searchKeyword = document.getElementById('searchInput').value.toLowerCase();
            let visibleCount = 0;

            const buttons = ['Semua', 'Proses', 'Selesai', 'Menunggu'];
            buttons.forEach(btn => {
                const btnElement = document.getElementById(`btn${btn}`);
                if (btnElement) {
                    if ((status === 'semua' && btn === 'Semua') ||
                        (status === 'proses' && btn === 'Proses') ||
                        (status === 'selesai' && btn === 'Selesai') ||
                        (status === 'menunggu' && btn === 'Menunggu')) {
                        btnElement.classList.remove('filter-inactive');
                        btnElement.classList.add('filter-active');
                    } else {
                        btnElement.classList.remove('filter-active');
                        btnElement.classList.add('filter-inactive');
                    }
                }
            });

            cards.forEach(card => {
                let show = true;
                const cardStatus = card.getAttribute('data-status');
                const searchText = card.getAttribute('data-search');

                if (status !== 'semua' && cardStatus !== status) {
                    show = false;
                }

                if (searchKeyword && !searchText.includes(searchKeyword)) {
                    show = false;
                }

                if (show) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const filterInfo = document.getElementById('filterInfo');
            const filterStatusText = document.getElementById('filterStatusText');

            if (status !== 'semua') {
                let statusName = '';
                if (status === 'proses') statusName = 'Dalam Proses';
                else if (status === 'selesai') statusName = 'Selesai';
                else if (status === 'menunggu') statusName = 'Menunggu / Belum Diproses';
                filterStatusText.innerText = statusName;
                filterInfo.classList.remove('hidden');
            } else {
                filterInfo.classList.add('hidden');
            }

            const container = document.getElementById('laporanContainer');
            let noResultMsg = document.getElementById('noResultMsg');
            if (visibleCount === 0 && cards.length > 0) {
                if (!noResultMsg) {
                    const msg = document.createElement('div');
                    msg.id = 'noResultMsg';
                    msg.className = 'col-span-2 text-center py-8 text-gray-500';
                    msg.innerHTML = '<i class="fas fa-search text-4xl mb-2 block"></i>Tidak ada laporan yang ditemukan';
                    container.appendChild(msg);
                }
            } else {
                if (noResultMsg) noResultMsg.remove();
            }
        }

        function resetFilter() {
            currentFilter = 'semua';
            document.getElementById('searchInput').value = '';
            filterByStatus('semua');
        }

        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                filterByStatus(currentFilter);
            });
        }

        // ==================== MODAL PROFIL ====================
        function openProfileModal() {
            document.getElementById('profileModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeProfileModal() {
            document.getElementById('profileModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // ==================== MODAL GANTI PASSWORD ====================
        function openGantiPasswordModal() {
            closeProfileModal();
            document.getElementById('gantiPasswordModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeGantiPasswordModal() {
            document.getElementById('gantiPasswordModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // ==================== TOGGLE PASSWORD ====================
        function togglePasswordGanti(inputId, iconId) {
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

        // Image Modal
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

        // Close modals on backdrop click
        window.onclick = function(e) {
            if (e.target === document.getElementById('profileModal')) closeProfileModal();
            if (e.target === document.getElementById('gantiPasswordModal')) closeGantiPasswordModal();
            if (e.target === document.getElementById('imageModal')) closeImageModal();
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
                closeProfileModal();
                closeGantiPasswordModal();
            }
        });
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
