<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Semua Laporan | SIPASSA</title>

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
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -12px rgba(245, 158, 11, 0.3);
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

        /* Tombol Back to Top */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4);
        }

        .gradient-text {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
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

    <nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-amber-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-br-4xl">
                        <img src="{{ asset('images/logo-skaju.png') }}" alt="Logo SIPASSA"
                            class="w-8 h-8 object-contain">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold gradient-text">SIPASSA</h1>
                        <p class="text-xs text-gray-500">SMK Negeri 7 Batam</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="/" class="text-gray-600 hover:text-[#d97706] transition">Beranda</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Semua Laporan Pengaduan</h1>
            <p class="text-gray-600">Daftar lengkap laporan kerusakan sarana sekolah</p>
        </div>

        <!-- STATISTIK CARD -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-amber-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-xs">Total Laporan</p>
                        <p class="text-2xl font-bold text-gray-800" id="totalCount">0</p>
                    </div>
                    <i class="fas fa-clipboard-list text-amber-500 text-xl"></i>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-green-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-xs">Selesai</p>
                        <p class="text-2xl font-bold text-green-600" id="selesaiCount">0</p>
                    </div>
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-blue-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-xs">Diproses</p>
                        <p class="text-2xl font-bold text-blue-600" id="prosesCount">0</p>
                    </div>
                    <i class="fas fa-spinner fa-pulse text-blue-500 text-xl"></i>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-purple-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-xs">Menunggu</p>
                        <p class="text-2xl font-bold text-purple-600" id="menungguCount">0</p>
                    </div>
                    <i class="fas fa-clock text-purple-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- TOMBOL FILTER -->
        <div class="mb-4 flex flex-wrap justify-between items-center gap-3">
            <div class="flex flex-wrap gap-2">
                <button onclick="openFilterModal()"
                    class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                    <i class="fas fa-filter"></i> Filter
                    <span id="activeFilterBadge"
                        class="hidden bg-white text-amber-600 rounded-full px-1.5 py-0.5 text-xs"></span>
                </button>
                <button onclick="resetAllFilters()" id="resetFilterBtn"
                    class="hidden bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                    <i class="fas fa-undo-alt"></i> Reset
                </button>
            </div>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="searchInput" placeholder="Cari nama/kategori/lokasi..."
                    class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm w-80 focus:ring-2 focus:ring-amber-500">
            </div>
        </div>

        <!-- FILTER INFO -->
        <div id="filterInfo" class="text-xs text-gray-500 mb-3 hidden">
            <i class="fas fa-filter text-amber-500"></i> Menampilkan: <span id="filterStatusText">Semua</span> laporan
            <button onclick="resetAllFilters()" class="text-amber-500 hover:underline ml-2">
                <i class="fas fa-times-circle"></i> Hapus filter
            </button>
        </div>

        <!-- DAFTAR LAPORAN - 3 CARD PER BARIS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="laporanContainer">
            @forelse($laporan as $l)
                @php
                    $statusText = $l->aspirasi->status ?? 'Belum diproses';
                    $feedbackText = $l->aspirasi->feedback ?? null;
                    $feedbackTime = $l->aspirasi->updated_at ?? $l->aspirasi->created_at;
                    $formattedFeedbackTime = $feedbackTime ? date('d/m/Y H:i:s', strtotime($feedbackTime)) : '-';
                    $kategoriNama = $l->kategori->ket_kategori ?? 'Umum';
                    $siswaNama = $l->siswa->nama ?? 'Siswa';
                    $siswaNis = $l->nis ?? '';
                    $tanggal = $l->created_at ? date('d/m/Y H:i', strtotime($l->created_at)) : '-';
                    $tanggalFilter = $l->created_at ? date('Y-m-d', strtotime($l->created_at)) : '';
                    $bulanFilter = $l->created_at ? date('m', strtotime($l->created_at)) : '';
                    $tahunFilter = $l->created_at ? date('Y', strtotime($l->created_at)) : '';

                    $badgeClass = 'bg-gray-100 text-gray-700';
                    $statusIcon = 'fa-hourglass-half';
                    if ($statusText == 'Selesai') {
                        $badgeClass = 'bg-green-100 text-green-700';
                        $statusIcon = 'fa-check-circle';
                    } elseif ($statusText == 'Dalam Proses') {
                        $badgeClass = 'bg-blue-100 text-blue-700';
                        $statusIcon = 'fa-spinner fa-pulse';
                    } elseif ($statusText == 'Menunggu Proses') {
                        $badgeClass = 'bg-yellow-100 text-yellow-700';
                        $statusIcon = 'fa-clock';
                    } else {
                        $badgeClass = 'bg-gray-100 text-gray-700';
                        $statusIcon = 'fa-hourglass-half';
                    }
                @endphp
                <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border border-gray-100 laporan-card"
                    data-status="{{ $statusText }}" data-tanggal="{{ $tanggalFilter }}"
                    data-bulan="{{ $bulanFilter }}" data-tahun="{{ $tahunFilter }}" data-siswa="{{ $siswaNis }}"
                    data-siswa-nama="{{ strtolower($siswaNama) }}"
                    data-search="{{ strtolower($siswaNama . ' ' . $kategoriNama . ' ' . $l->lokasi) }}">
                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 text-white">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-file-alt"></i>
                                <span class="font-semibold text-sm">Laporan #{{ $l->id_pelaporan }}</span>
                            </div>
                            <span class="status-badge {{ $badgeClass }} text-xs">
                                <i class="fas {{ $statusIcon }}"></i> {{ $statusText }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="mb-2">
                            <p class="text-xs text-gray-400"><i class="fas fa-user text-amber-500"></i> Pelapor</p>
                            <p class="text-sm font-medium text-gray-700">{{ $siswaNama }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="text-xs text-gray-400"><i class="fas fa-tag text-amber-500"></i> Kategori</p>
                            <p class="text-sm font-medium text-gray-700">{{ $kategoriNama }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="text-xs text-gray-400"><i class="fas fa-location-dot text-amber-500"></i> Lokasi
                            </p>
                            <p class="text-sm font-medium text-gray-700">{{ $l->lokasi }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="text-xs text-gray-400"><i class="fas fa-calendar-alt text-amber-500"></i>
                                Tanggal</p>
                            <p class="text-sm text-gray-600">{{ $tanggal }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="text-xs text-gray-400"><i class="fas fa-align-left text-amber-500"></i>
                                Keterangan</p>
                            <p class="text-sm text-gray-600 bg-gray-50 p-2 rounded-lg">{{ Str::limit($l->ket, 100) }}
                            </p>
                        </div>
                        @if ($l->foto && file_exists(public_path($l->foto)))
                            <div class="mt-2">
                                <img src="{{ asset($l->foto) }}" alt="Foto"
                                    class="w-20 h-20 object-cover rounded-lg shadow-sm cursor-pointer"
                                    onclick="window.open('{{ asset($l->foto) }}', '_blank')">
                            </div>
                        @endif

                        <!-- FEEDBACK ADMIN dengan TOOLTIP -->
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-400 flex items-center gap-1 mb-1">
                                <i class="fas fa-comment-dots text-amber-500"></i> Feedback Admin
                            </p>
                            <div class="bg-blue-50 p-2 rounded-lg">
                                @if ($feedbackText)
                                    <div class="feedback-tooltip">
                                        <p class="text-sm text-gray-700">{{ $feedbackText }}</p>
                                        <div class="tooltip-text">
                                            <i class="fas fa-calendar-alt mr-1"></i> {{ $formattedFeedbackTime }}<br>
                                            <i class="fas fa-user-check mr-1"></i> Oleh: {{ $l->aspirasi->username ?? 'Admin' }}
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <p class="text-xs text-blue-500 flex items-center gap-1">
                                            <i class="fas fa-check-circle"></i> Sudah ditanggapi
                                        </p>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-400 italic">Belum ada feedback</p>
                                    <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                        <i class="fas fa-clock"></i> Menunggu tanggapan admin
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-xl">
                    <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                    <p class="text-gray-400">Belum ada laporan yang masuk</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ==================== MODAL FILTER ==================== -->
    <div id="filterModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
        <div class="bg-white rounded-2xl max-w-lg w-full mx-4 modal-pop">
            <div class="bg-gradient-to-r from-[#d97706] to-[#f59e0b] px-6 py-4 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-2 rounded-full"><i class="fas fa-filter text-white"></i></div>
                        <div>
                            <h3 class="text-white text-xl font-bold">Filter Laporan</h3>
                            <p class="text-white/80 text-sm">Saring laporan berdasarkan kriteria</p>
                        </div>
                    </div>
                    <button onclick="closeFilterModal()" class="text-white/80 hover:text-white text-2xl"><i
                            class="fas fa-times"></i></button>
                </div>
            </div>

            <div class="p-6">
                <!-- Filter Per Akun/Siswa -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm flex items-center gap-2">
                        <i class="fas fa-user-graduate text-amber-500"></i> Filter Per Siswa
                    </label>
                    <select id="filterSiswa" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">Semua Siswa</option>
                        @php
                            $siswaList = \App\Models\Siswa::orderBy('nama', 'asc')->get();
                        @endphp
                        @foreach ($siswaList as $s)
                            <option value="{{ $s->nis }}">{{ $s->nama }} (NIS: {{ $s->nis }}) -
                                {{ $s->kelas }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Pilih siswa untuk melihat laporan miliknya saja</p>
                </div>

                <!-- Filter Tanggal -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-amber-500"></i> Filter Per Tanggal
                    </label>
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <input type="date" id="filterStartDate" placeholder="Dari tanggal"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        </div>
                        <div class="flex-1">
                            <input type="date" id="filterEndDate" placeholder="Sampai tanggal"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        </div>
                    </div>
                </div>

                <!-- Filter Bulan & Tahun -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm flex items-center gap-2">
                        <i class="fas fa-calendar-week text-amber-500"></i> Filter Per Bulan
                    </label>
                    <div class="flex gap-3">
                        <select id="filterMonth" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="">Semua Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <select id="filterYear" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="">Tahun</option>
                            @for ($year = 2023; $year <= date('Y') + 1; $year++)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                    {{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Filter Status -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm flex items-center gap-2">
                        <i class="fas fa-chart-line text-amber-500"></i> Filter Per Status
                    </label>
                    <select id="filterStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">Semua Status</option>
                        <option value="Selesai">✅ Selesai</option>
                        <option value="Dalam Proses">⚙️ Dalam Proses</option>
                        <option value="Menunggu Proses">⏳ Menunggu Proses</option>
                        <option value="Belum diproses">⏳ Belum Diproses</option>
                    </select>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex gap-3 mt-6">
                    <button onclick="applyFiltersFromModal()"
                        class="flex-1 btn-primary bg-gradient-to-r from-[#d97706] to-[#f59e0b] text-white py-2.5 rounded-lg font-semibold flex items-center justify-center gap-2">
                        <i class="fas fa-check"></i> Terapkan Filter
                    </button>
                    <button onclick="clearFilterModal()"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2.5 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                        <i class="fas fa-eraser"></i> Bersihkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Back to Top -->
    <div class="back-to-top" id="backToTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <i class="fas fa-arrow-up text-xl"></i>
    </div>

    <script>
        // Variabel untuk menyimpan status filter aktif
        let activeFilters = {
            siswa: '',
            startDate: '',
            endDate: '',
            month: '',
            year: '',
            status: ''
        };

        // Back to Top - muncul saat scroll
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        // Hitung statistik awal
        function updateStats() {
            const cards = document.querySelectorAll('.laporan-card');
            let total = cards.length;
            let selesai = 0,
                proses = 0,
                menunggu = 0,
                belum = 0;

            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                if (status == 'Selesai') selesai++;
                else if (status == 'Dalam Proses') proses++;
                else if (status == 'Menunggu Proses') menunggu++;
                else belum++;
            });

            document.getElementById('totalCount').innerText = total;
            document.getElementById('selesaiCount').innerText = selesai;
            document.getElementById('prosesCount').innerText = proses;
            document.getElementById('menungguCount').innerText = menunggu;
        }

        // Buka modal filter
        function openFilterModal() {
            document.getElementById('filterSiswa').value = activeFilters.siswa;
            document.getElementById('filterStartDate').value = activeFilters.startDate;
            document.getElementById('filterEndDate').value = activeFilters.endDate;
            document.getElementById('filterMonth').value = activeFilters.month;
            document.getElementById('filterYear').value = activeFilters.year;
            document.getElementById('filterStatus').value = activeFilters.status;

            document.getElementById('filterModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeFilterModal() {
            document.getElementById('filterModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function clearFilterModal() {
            document.getElementById('filterSiswa').value = '';
            document.getElementById('filterStartDate').value = '';
            document.getElementById('filterEndDate').value = '';
            document.getElementById('filterMonth').value = '';
            document.getElementById('filterYear').value = '{{ date('Y') }}';
            document.getElementById('filterStatus').value = '';
        }

        function applyFiltersFromModal() {
            activeFilters.siswa = document.getElementById('filterSiswa').value;
            activeFilters.startDate = document.getElementById('filterStartDate').value;
            activeFilters.endDate = document.getElementById('filterEndDate').value;
            activeFilters.month = document.getElementById('filterMonth').value;
            activeFilters.year = document.getElementById('filterYear').value;
            activeFilters.status = document.getElementById('filterStatus').value;

            closeFilterModal();
            applyFilters();
            updateFilterBadge();
        }

        function resetAllFilters() {
            activeFilters = {
                siswa: '',
                startDate: '',
                endDate: '',
                month: '',
                year: '',
                status: ''
            };
            document.getElementById('searchInput').value = '';
            applyFilters();
            updateFilterBadge();
        }

        function updateFilterBadge() {
            const badge = document.getElementById('activeFilterBadge');
            const resetBtn = document.getElementById('resetFilterBtn');
            let activeCount = 0;

            if (activeFilters.siswa) activeCount++;
            if (activeFilters.startDate && activeFilters.endDate) activeCount++;
            if (activeFilters.month) activeCount++;
            if (activeFilters.year) activeCount++;
            if (activeFilters.status) activeCount++;

            if (activeCount > 0) {
                badge.classList.remove('hidden');
                badge.innerHTML = activeCount;
                resetBtn.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
                resetBtn.classList.add('hidden');
            }
        }

        function applyFilters() {
            const cards = document.querySelectorAll('.laporan-card');
            const searchKeyword = document.getElementById('searchInput').value.toLowerCase().trim();
            let visibleCount = 0;

            cards.forEach(card => {
                let show = true;
                const cardTanggal = card.getAttribute('data-tanggal');
                const cardBulan = card.getAttribute('data-bulan');
                const cardTahun = card.getAttribute('data-tahun');
                const cardStatus = card.getAttribute('data-status');
                const cardSiswa = card.getAttribute('data-siswa');
                const searchText = card.getAttribute('data-search');

                // Filter siswa
                if (activeFilters.siswa && activeFilters.siswa !== '') {
                    if (cardSiswa !== activeFilters.siswa) show = false;
                }

                // Filter tanggal
                if (activeFilters.startDate && activeFilters.endDate) {
                    if (cardTanggal < activeFilters.startDate || cardTanggal > activeFilters.endDate) show = false;
                }

                // Filter bulan & tahun
                if (activeFilters.month && activeFilters.month !== '') {
                    if (cardBulan !== activeFilters.month) show = false;
                }
                if (activeFilters.year && activeFilters.year !== '') {
                    if (cardTahun !== activeFilters.year) show = false;
                }

                // Filter status
                if (activeFilters.status && activeFilters.status !== '') {
                    if (cardStatus !== activeFilters.status) show = false;
                }

                // Filter search
                if (searchKeyword !== '') {
                    if (!searchText || !searchText.includes(searchKeyword)) show = false;
                }

                if (show) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update info filter
            const filterInfo = document.getElementById('filterInfo');
            const filterStatusText = document.getElementById('filterStatusText');

            if (activeFilters.status && activeFilters.status !== '') {
                let statusName = '';
                if (activeFilters.status === 'Selesai') statusName = 'Selesai';
                else if (activeFilters.status === 'Dalam Proses') statusName = 'Dalam Proses';
                else if (activeFilters.status === 'Menunggu Proses') statusName = 'Menunggu Proses';
                else if (activeFilters.status === 'Belum diproses') statusName = 'Belum Diproses';
                filterStatusText.innerText = statusName;
                filterInfo.classList.remove('hidden');
            } else if (activeFilters.siswa) {
                const siswaSelect = document.getElementById('filterSiswa');
                const siswaName = siswaSelect.options[siswaSelect.selectedIndex]?.text || 'Siswa';
                filterStatusText.innerText = siswaName;
                filterInfo.classList.remove('hidden');
            } else if (activeFilters.startDate && activeFilters.endDate) {
                filterStatusText.innerText = `${activeFilters.startDate} s/d ${activeFilters.endDate}`;
                filterInfo.classList.remove('hidden');
            } else if (activeFilters.month && activeFilters.year) {
                const bulanMap = {
                    '01': 'Januari',
                    '02': 'Februari',
                    '03': 'Maret',
                    '04': 'April',
                    '05': 'Mei',
                    '06': 'Juni',
                    '07': 'Juli',
                    '08': 'Agustus',
                    '09': 'September',
                    '10': 'Oktober',
                    '11': 'November',
                    '12': 'Desember'
                };
                filterStatusText.innerText = `${bulanMap[activeFilters.month]} ${activeFilters.year}`;
                filterInfo.classList.remove('hidden');
            } else {
                filterInfo.classList.add('hidden');
            }

            // Tampilkan pesan jika tidak ada hasil
            const container = document.getElementById('laporanContainer');
            let noResultMsg = document.getElementById('noResultMsg');
            if (visibleCount === 0 && cards.length > 0) {
                if (!noResultMsg) {
                    const msg = document.createElement('div');
                    msg.id = 'noResultMsg';
                    msg.className = 'col-span-full text-center py-8 text-gray-500';
                    msg.innerHTML =
                        '<i class="fas fa-search text-4xl mb-2 block"></i>Tidak ada laporan yang ditemukan<br><span class="text-xs">Coba ubah filter atau kata kunci pencarian</span>';
                    container.appendChild(msg);
                }
            } else {
                if (noResultMsg) noResultMsg.remove();
            }
        }

        // Search input
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                applyFilters();
            });
        }

        function openRole() {
            window.location.href = '/';
        }

        // Close modal on backdrop click
        window.onclick = function(e) {
            if (e.target === document.getElementById('filterModal')) closeFilterModal();
        }

        // Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('filterModal').style.display === 'flex')
                closeFilterModal();
        });

        // Jalankan update statistik dan filter setelah halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            updateStats();
            applyFilters();
        });
    </script>

</body>

</html>