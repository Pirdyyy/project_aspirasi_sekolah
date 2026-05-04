<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Dashboard Admin | SIPASSA</title>

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

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
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
                        class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/20 transition"><i
                            class="fas fa-tachometer-alt w-5"></i><span>Dashboard</span></a>
                    <a href="/admin/kategori"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition mt-1"><i
                            class="fas fa-tags w-5"></i><span>Manajemen Kategori</span></a>
                    <a href="/admin/kelola-siswa"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition mt-1">
                        <i class="fas fa-users w-5"></i>
                        <span>Kelola Siswa</span>
                    </a>
                </div>
            </nav>
            
            <!-- Profil di Sidebar (Bisa diklik) -->
            <div onclick="openProfileModal()" 
                class="absolute bottom-0 w-72 p-4 border-t border-white/20 cursor-pointer hover:bg-white/10 transition">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm truncate">
                            {{ $admin->nama_admin ?? ($admin->username ?? 'Admin') }}
                        </p>
                        <p class="text-xs text-white/70">Administrator</p>
                    </div>
                    <i class="fas fa-chevron-right text-xs text-white/50"></i>
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
                <h1 class="text-3xl font-bold gradient-text">Dashboard Admin</h1>
                <p class="text-gray-600">Kelola dan tanggapi laporan kerusakan sarana sekolah</p>
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
            @endphp

            <!-- STATISTIK CARD -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
                <div class="bg-white rounded-2xl p-5 shadow-lg border-l-8 border-l-amber-500 card-hover">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Total Laporan</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalLaporan }}</p>
                        </div>
                        <div class="bg-amber-100 p-3 rounded-xl"><i
                                class="fas fa-clipboard-list text-amber-600 text-xl"></i></div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-lg border-l-8 border-l-blue-500 card-hover">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Diproses</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $proses }}</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-xl"><i
                                class="fas fa-spinner fa-pulse text-blue-600 text-xl"></i></div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-lg border-l-8 border-l-green-500 card-hover">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Selesai</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $selesai }}</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-xl"><i
                                class="fas fa-check-circle text-green-600 text-xl"></i></div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-lg border-l-8 border-l-purple-500 card-hover">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Menunggu</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $pending }}</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-xl"><i
                                class="fas fa-clock text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOMBOL FILTER + SEARCH -->
            <div class="mb-4 flex justify-between items-center flex-wrap gap-3">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-list-ul text-amber-500"></i> Semua Laporan
                        <span id="laporanCount"
                            class="text-sm font-normal text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">{{ $totalLaporan }}</span>
                    </h2>

                    <!-- TOMBOL FILTER (SATU TOMBOL) -->
                    <button onclick="openFilterModal()"
                        class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                        <i class="fas fa-filter"></i> Filter
                        <span id="activeFilterBadge"
                            class="hidden bg-white text-amber-600 rounded-full px-1.5 py-0.5 text-xs"></span>
                    </button>

                    <!-- TOMBOL RESET FILTER -->
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

            <!-- DAFTAR LAPORAN - CARD VIEW -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="laporanContainer">
                @forelse($data as $d)
                    @php
                        $statusText = $d->aspirasi->status ?? 'Belum diproses';
                        $feedbackText = $d->aspirasi->feedback ?? 'Belum ada feedback';
                        $siswaNama = $d->siswa->nama ?? 'Tidak diketahui';
                        $kategoriNama = $d->kategori->ket_kategori ?? 'Umum';
                        $tanggalLaporan = $d->created_at ? date('d-m-Y', strtotime($d->created_at)) : '-';

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
                        }
                    @endphp
                    <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border border-gray-100 laporan-card"
                        data-id="{{ $d->id_pelaporan }}"
                        data-tanggal="{{ $d->created_at ? date('Y-m-d', strtotime($d->created_at)) : '' }}"
                        data-bulan="{{ $d->created_at ? date('m', strtotime($d->created_at)) : '' }}"
                        data-tahun="{{ $d->created_at ? date('Y', strtotime($d->created_at)) : '' }}"
                        data-kategori="{{ $d->id_kategori }}"
                        data-siswa-nis="{{ $d->nis }}"
                        data-search="{{ strtolower($siswaNama . ' ' . $kategoriNama . ' ' . $d->lokasi) }}">

                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 text-white">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <div class="bg-white/20 p-1.5 rounded-full"><i
                                            class="fas fa-user-graduate text-sm"></i></div>
                                    <div>
                                        <p class="font-semibold text-sm">{{ $siswaNama }}</p>
                                        <p class="text-xs text-white/80">NIS: {{ $d->nis }} •
                                            {{ $tanggalLaporan }}</p>
                                    </div>
                                </div>
                                <span class="status-badge {{ $badgeClass }} text-xs"><i
                                        class="fas {{ $statusIcon }}"></i> {{ $statusText }}</span>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div>
                                    <p class="text-xs text-gray-400"><i class="fas fa-tag text-amber-500"></i>
                                        Kategori</p>
                                    <p class="text-sm font-medium text-gray-700">{{ $kategoriNama }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400"><i
                                            class="fas fa-location-dot text-amber-500"></i> Lokasi</p>
                                    <p class="text-sm font-medium text-gray-700">{{ $d->lokasi }}</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="text-xs text-gray-400"><i class="fas fa-align-left text-amber-500"></i>
                                    Keterangan</p>
                                <p class="text-sm text-gray-600 bg-gray-50 p-2 rounded-lg">
                                    {{ Str::limit($d->ket, 100) }}</p>
                            </div>

                            @if ($d->foto && file_exists(public_path($d->foto)))
                                <div class="mb-3">
                                    <p class="text-xs text-gray-400"><i class="fas fa-image text-amber-500"></i>
                                        Foto
                                    </p><img src="{{ asset($d->foto) }}" alt="Foto"
                                        class="w-20 h-20 object-cover rounded-lg mt-1 shadow-sm cursor-pointer"
                                        onclick="window.open('{{ asset($d->foto) }}', '_blank')">
                                </div>
                            @endif

                            <button type="button"
                                onclick="openReplyModal('{{ $d->id_pelaporan }}','{{ addslashes($siswaNama) }}','{{ addslashes($kategoriNama) }}','{{ addslashes($d->lokasi) }}','{{ addslashes($d->ket) }}','{{ addslashes($statusText) }}','{{ addslashes($feedbackText) }}','{{ $d->foto ? asset($d->foto) : '' }}')"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2.5 rounded-lg text-sm font-semibold transition flex items-center justify-center gap-2"><i
                                    class="fas fa-eye"></i> Lihat & Balas</button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12 bg-white rounded-xl"><i
                            class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-400">Belum ada laporan dari siswa</p>
                    </div>
                @endforelse
            </div>

        </main>
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
                <!-- Filter Per Siswa -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm flex items-center gap-2">
                        <i class="fas fa-user-graduate text-amber-500"></i> Filter Per Siswa
                    </label>
                    <select id="filterSiswa" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">Semua Siswa</option>
                        @foreach ($allSiswa as $s)
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
                        <select id="filterMonth"
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
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
                        <select id="filterYear"
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="">Tahun</option>
                            @for ($year = 2023; $year <= date('Y') + 1; $year++)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                    {{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Filter Kategori -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm flex items-center gap-2">
                        <i class="fas fa-tags text-amber-500"></i> Filter Per Kategori
                    </label>
                    <select id="filterCategory"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id_kategori }}">{{ $k->ket_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex gap-3 mt-6">
                    <button onclick="applyFiltersFromModal()"
                        class="flex-1 btn-primary text-white py-2.5 rounded-lg font-semibold flex items-center justify-center gap-2">
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

    <!-- ==================== MODAL BALAS LAPORAN ==================== -->
    <div id="replyModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
        <div class="bg-white rounded-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto modal-pop">
            <div class="bg-gradient-to-r from-[#d97706] to-[#f59e0b] px-6 py-4 sticky top-0 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-2 rounded-full"><i class="fas fa-reply-all text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-white text-xl font-bold">Balas Laporan</h3>
                            <p class="text-white/80 text-sm">Berikan tanggapan untuk siswa</p>
                        </div>
                    </div>
                    <button onclick="closeReplyModal()" class="text-white/80 hover:text-white text-2xl"><i
                            class="fas fa-times"></i></button>
                </div>
            </div>
            <form id="replyForm" method="POST" class="p-6">
                @csrf
                <input type="hidden" id="laporanId" name="laporan_id">
                <div class="bg-amber-50 rounded-xl p-4 mb-5">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2"><i
                            class="fas fa-info-circle text-amber-500"></i> Detail Laporan</h4>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div><span class="text-gray-500">Siswa:</span>
                            <p id="detailSiswa" class="font-medium text-gray-800">-</p>
                        </div>
                        <div><span class="text-gray-500">Kategori:</span>
                            <p id="detailKategori" class="font-medium text-gray-800">-</p>
                        </div>
                        <div><span class="text-gray-500">Lokasi:</span>
                            <p id="detailLokasi" class="font-medium text-gray-800">-</p>
                        </div>
                        <div><span class="text-gray-500">Status:</span>
                            <p id="detailStatus" class="font-medium">-</p>
                        </div>
                    </div>
                    <div class="mt-3"><span class="text-gray-500 text-sm">Keterangan:</span>
                        <p id="detailKeterangan" class="text-gray-700 bg-white p-2 rounded-lg mt-1 text-sm">-</p>
                    </div>
                    <div id="detailFotoContainer" class="mt-3 hidden"><span class="text-gray-500 text-sm">Foto
                            Laporan:</span><img id="detailFoto" src="" alt="Foto"
                            class="w-32 h-32 object-cover rounded-lg mt-1 shadow-sm"></div>
                </div>
                <div class="mb-5"><label class="block text-gray-700 font-semibold mb-2 text-sm"><i
                            class="fas fa-chart-line text-amber-500"></i> Update Status</label><select
                            name="status" id="statusSelect"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <option value="Belum diproses">⏳ Belum diproses</option>
                            <option value="Menunggu Proses">⏳ Menunggu Proses</option>
                            <option value="Dalam Proses">⚙️ Dalam Proses</option>
                            <option value="Selesai">✅ Selesai</option>
                        </select></div>
                    <div class="mb-5"><label class="block text-gray-700 font-semibold mb-2 text-sm"><i
                                class="fas fa-comment-dots text-amber-500"></i> Feedback</label>
                        <textarea name="feedback" id="feedbackText" rows="4"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl resize-none"
                            placeholder="Tulis tanggapan untuk siswa..."></textarea>
                    </div>
                    <div class="flex gap-3 mt-6"><button type="submit"
                            class="flex-1 btn-primary text-white py-3 rounded-xl font-semibold"><i
                                class="fas fa-paper-plane"></i> Kirim Balasan</button><button type="button"
                            onclick="closeReplyModal()"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ==================== MODAL PROFIL ADMIN ==================== -->
        <div id="profileModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
            <div class="bg-white rounded-2xl max-w-md w-full mx-4 overflow-hidden modal-pop">
                <div class="bg-gradient-to-r from-[#d97706] to-[#f59e0b] px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 p-2 rounded-full">
                                <i class="fas fa-user-shield text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-white text-xl font-bold">Profil Admin</h3>
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
                            <span class="text-gray-500 text-sm">Username</span>
                            <span class="font-semibold text-gray-800">{{ $admin->username ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                            <span class="text-gray-500 text-sm">Nama Admin</span>
                            <span class="font-semibold text-gray-800">{{ $admin->nama_admin ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                            <span class="text-gray-500 text-sm">Total Laporan</span>
                            <span class="font-semibold text-amber-600">{{ $totalLaporan }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-sm">Status Akun</span>
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">
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

        <!-- ==================== MODAL GANTI PASSWORD ADMIN ==================== -->
        <div id="gantiPasswordModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
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
                <form action="/admin/ganti-password" method="POST" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2 text-sm">Password Lama</label>
                        <div class="relative">
                            <input type="password" name="password_lama" id="passwordLama" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 pr-10"
                                placeholder="Masukkan password lama Anda">
                            <button type="button" onclick="togglePasswordAdmin('passwordLama', 'eyeLama')"
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
                            <button type="button" onclick="togglePasswordAdmin('passwordBaru', 'eyeBaru')"
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
                            <button type="button" onclick="togglePasswordAdmin('passwordKonfirmasi', 'eyeKonfirmasi')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-amber-500">
                                <i id="eyeKonfirmasi" class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button type="submit" class="flex-1 btn-primary text-white py-2 rounded-xl font-semibold">
                            <i class="fas fa-save"></i> Ganti Password
                        </button>
                        <button type="button" onclick="closeGantiPasswordModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-xl font-semibold transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            // Variabel untuk menyimpan status filter aktif
            let activeFilters = {
                startDate: '',
                endDate: '',
                month: '',
                year: '',
                category: '',
                siswa: ''
            };

            // Buka modal filter
            function openFilterModal() {
                document.getElementById('filterStartDate').value = activeFilters.startDate;
                document.getElementById('filterEndDate').value = activeFilters.endDate;
                document.getElementById('filterMonth').value = activeFilters.month;
                document.getElementById('filterYear').value = activeFilters.year;
                document.getElementById('filterCategory').value = activeFilters.category;
                document.getElementById('filterSiswa').value = activeFilters.siswa;

                document.getElementById('filterModal').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }

            function closeFilterModal() {
                document.getElementById('filterModal').style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            function applyFiltersFromModal() {
                activeFilters.startDate = document.getElementById('filterStartDate').value;
                activeFilters.endDate = document.getElementById('filterEndDate').value;
                activeFilters.month = document.getElementById('filterMonth').value;
                activeFilters.year = document.getElementById('filterYear').value;
                activeFilters.category = document.getElementById('filterCategory').value;
                activeFilters.siswa = document.getElementById('filterSiswa').value;

                closeFilterModal();
                applyFilters();
                updateFilterBadge();
            }

            function clearFilterModal() {
                document.getElementById('filterStartDate').value = '';
                document.getElementById('filterEndDate').value = '';
                document.getElementById('filterMonth').value = '';
                document.getElementById('filterYear').value = '{{ date('Y') }}';
                document.getElementById('filterCategory').value = '';
                document.getElementById('filterSiswa').value = '';
            }

            function resetAllFilters() {
                activeFilters = {
                    startDate: '',
                    endDate: '',
                    month: '',
                    year: '',
                    category: '',
                    siswa: ''
                };
                document.getElementById('searchInput').value = '';
                applyFilters();
                updateFilterBadge();
            }

            function updateFilterBadge() {
                const badge = document.getElementById('activeFilterBadge');
                const resetBtn = document.getElementById('resetFilterBtn');
                let activeCount = 0;

                if (activeFilters.startDate && activeFilters.endDate) activeCount++;
                if (activeFilters.month) activeCount++;
                if (activeFilters.year) activeCount++;
                if (activeFilters.category) activeCount++;
                if (activeFilters.siswa) activeCount++;

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
                    const cardKategori = card.getAttribute('data-kategori');
                    const cardSiswaNis = card.getAttribute('data-siswa-nis');
                    const searchText = card.getAttribute('data-search');

                    if (activeFilters.siswa && activeFilters.siswa !== '') {
                        if (cardSiswaNis != activeFilters.siswa) show = false;
                    }
                    if (activeFilters.startDate && activeFilters.endDate) {
                        if (cardTanggal < activeFilters.startDate || cardTanggal > activeFilters.endDate) show = false;
                    }
                    if (activeFilters.month && activeFilters.month !== '') {
                        if (cardBulan !== activeFilters.month) show = false;
                    }
                    if (activeFilters.year && activeFilters.year !== '') {
                        if (cardTahun !== activeFilters.year) show = false;
                    }
                    if (activeFilters.category && activeFilters.category !== '') {
                        if (cardKategori != activeFilters.category) show = false;
                    }
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

                const laporanCountSpan = document.getElementById('laporanCount');
                if (laporanCountSpan) laporanCountSpan.innerHTML = visibleCount;

                updateFilterBadge();

                const container = document.getElementById('laporanContainer');
                let noResultMsg = document.getElementById('noResultMsg');
                if (visibleCount === 0 && cards.length > 0) {
                    if (!noResultMsg && container) {
                        const msg = document.createElement('div');
                        msg.id = 'noResultMsg';
                        msg.className = 'col-span-2 text-center py-8 text-gray-500';
                        msg.innerHTML =
                            '<i class="fas fa-search text-4xl mb-2 block"></i>Tidak ada laporan yang ditemukan<br><span class="text-xs">Coba ubah filter atau kata kunci pencarian</span>';
                        container.appendChild(msg);
                    }
                } else {
                    if (noResultMsg) noResultMsg.remove();
                }
            }

            document.getElementById('searchInput').addEventListener('keyup', function() {
                applyFilters();
            });

            // Modal Reply Functions
            function openReplyModal(id, siswa, kategori, lokasi, keterangan, status, feedback, foto) {
                document.getElementById('replyForm').action = '/update/status/' + id;
                document.getElementById('laporanId').value = id;
                document.getElementById('detailSiswa').innerText = siswa;
                document.getElementById('detailKategori').innerText = kategori;
                document.getElementById('detailLokasi').innerText = lokasi;
                document.getElementById('detailKeterangan').innerText = keterangan;

                const statusSelect = document.getElementById('statusSelect');
                if (status == 'Selesai') statusSelect.value = 'Selesai';
                else if (status == 'Dalam Proses') statusSelect.value = 'Dalam Proses';
                else if (status == 'Menunggu Proses') statusSelect.value = 'Menunggu Proses';
                else statusSelect.value = 'Belum diproses';

                const feedbackTextarea = document.getElementById('feedbackText');
                feedbackTextarea.value = (feedback && feedback != 'Belum ada feedback') ? feedback : '';

                const fotoContainer = document.getElementById('detailFotoContainer');
                const fotoImg = document.getElementById('detailFoto');
                if (foto && foto != '') {
                    fotoImg.src = foto;
                    fotoContainer.classList.remove('hidden');
                } else {
                    fotoContainer.classList.add('hidden');
                }

                document.getElementById('replyModal').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }

            function closeReplyModal() {
                document.getElementById('replyModal').style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            // ==================== MODAL PROFIL ADMIN ====================
            function openProfileModal() {
                document.getElementById('profileModal').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }

            function closeProfileModal() {
                document.getElementById('profileModal').style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            // ==================== MODAL GANTI PASSWORD ADMIN ====================
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
            function togglePasswordAdmin(inputId, iconId) {
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

            window.onclick = function(e) {
                if (e.target === document.getElementById('filterModal')) closeFilterModal();
                if (e.target === document.getElementById('replyModal')) closeReplyModal();
                if (e.target === document.getElementById('profileModal')) closeProfileModal();
                if (e.target === document.getElementById('gantiPasswordModal')) closeGantiPasswordModal();
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (document.getElementById('filterModal').style.display === 'flex') closeFilterModal();
                    if (document.getElementById('replyModal').style.display === 'flex') closeReplyModal();
                    if (document.getElementById('profileModal').style.display === 'flex') closeProfileModal();
                    if (document.getElementById('gantiPasswordModal').style.display === 'flex') closeGantiPasswordModal();
                }
            });
        </script>

        @if (session('success'))
            <div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
                <i class="fas fa-check-circle"></i><span>{{ session('success') }}</span><button
                    onclick="this.parentElement.remove()" class="ml-3"><i class="fas fa-times"></i></button>
            </div>
        @endif
        @if (session('error'))
            <div class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i><span>{{ session('error') }}</span><button
                    onclick="this.parentElement.remove()" class="ml-3"><i class="fas fa-times"></i></button>
            </div>
        @endif

    </body>

    </html>