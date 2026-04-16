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
                    <a href="/dashboard-admin"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/20 transition">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="/admin/kategori"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition mt-1">
                        <i class="fas fa-tags w-5"></i>
                        <span>Manajemen Kategori</span>
                    </a>
                </div>
            </nav>
            {{-- test perubahan --}}

            <div class="absolute bottom-0 w-72 p-4 border-t border-white/20">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm truncate">
                            {{ $admin->nama_admin ?? ($admin->username ?? 'Admin') }}</p>
                        <p class="text-xs text-white/70">Administrator</p>
                    </div>
                </div>
                <a href="/logout-admin" onclick="return confirm('Yakin logout?')"
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
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
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

            <!-- ==================== STATISTIK DINAMIS DARI DATABASE ==================== -->
            <section class="bg-white py-12 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        <!-- 1. Kategori Sarana -->
                        <div data-aos="zoom-in" data-aos-delay="0">
                            <div
                                class="bg-amber-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-building text-2xl text-amber-600"></i>
                            </div>
                            <div class="text-2xl font-bold text-gray-800">{{ $totalKategori }}</div>
                            <div class="text-sm text-gray-500">Kategori Sarana</div>
                        </div>

                        <!-- 2. Siswa Terdaftar -->
                        <div data-aos="zoom-in" data-aos-delay="100">
                            <div
                                class="bg-amber-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-users text-2xl text-amber-600"></i>
                            </div>
                            <div class="text-2xl font-bold text-gray-800">{{ $totalSiswa }}</div>
                            <div class="text-sm text-gray-500">Siswa Terdaftar</div>
                        </div>

                        <!-- 3. Laporan Selesai (HIJAU) -->
                        <div data-aos="zoom-in" data-aos-delay="200">
                            <div
                                class="bg-green-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-check-circle text-2xl text-green-600"></i>
                            </div>
                            <div class="text-2xl font-bold text-green-600">{{ $laporanSelesai }}</div>
                            <div class="text-sm text-gray-500">Laporan Selesai</div>
                        </div>

                        <!-- 4. Laporan Menunggu (UNGU) -->
                        <div data-aos="zoom-in" data-aos-delay="300">
                            <div
                                class="bg-purple-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-clock text-2xl text-purple-600"></i>
                            </div>
                            <div class="text-2xl font-bold text-purple-600">{{ $laporanMenunggu }}</div>
                            <div class="text-sm text-gray-500">Menunggu Respon</div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- DAFTAR LAPORAN - CARD VIEW -->
            <div class="mb-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-list-ul text-amber-500"></i> Semua Laporan
                </h2>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="searchInput" placeholder="Cari laporan..."
                        class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm w-64 focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="laporanContainer">
                @forelse($data as $d)
                    @php
                        $statusText = $d->aspirasi->status ?? 'Belum diproses';
                        $feedbackText = $d->aspirasi->feedback ?? 'Belum ada feedback';
                        $siswaNama = $d->siswa->nama ?? 'Tidak diketahui';
                        $kategoriNama = $d->kategori->ket_kategori ?? 'Umum';

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
                        data-search="{{ $siswaNama }} {{ $kategoriNama }} {{ $d->lokasi }}">
                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 text-white">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <div class="bg-white/20 p-1.5 rounded-full">
                                        <i class="fas fa-user-graduate text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm">{{ $siswaNama }}</p>
                                        <p class="text-xs text-white/80">NIS: {{ $d->nis }}</p>
                                    </div>
                                </div>
                                <span class="status-badge {{ $badgeClass }} text-xs">
                                    <i class="fas {{ $statusIcon }}"></i> {{ $statusText }}
                                </span>
                            </div>
                        </div>

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

                            @if ($d->foto && file_exists(public_path($d->foto)))
                                <div class="mb-3">
                                    <p class="text-xs text-gray-400 flex items-center gap-1">
                                        <i class="fas fa-image text-amber-500"></i> Foto
                                    </p>
                                    <img src="{{ asset($d->foto) }}" alt="Foto"
                                        class="w-20 h-20 object-cover rounded-lg mt-1 shadow-sm">
                                </div>
                            @endif

                            <!-- TOMBOL LIHAT & BALAS - PAKAI DATA-ATTRIBUTE -->
                            <button type="button"
                                onclick="openReplyModal(
                                '{{ $d->id_pelaporan }}',
                                '{{ addslashes($siswaNama) }}',
                                '{{ addslashes($kategoriNama) }}',
                                '{{ addslashes($d->lokasi) }}',
                                '{{ addslashes($d->ket) }}',
                                '{{ addslashes($statusText) }}',
                                '{{ addslashes($feedbackText) }}',
                                '{{ $d->foto ? asset($d->foto) : '' }}'
                            )"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-lg text-sm font-semibold transition flex items-center justify-center gap-2">
                                <i class="fas fa-eye"></i> Lihat & Balas
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12 bg-white rounded-xl">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-400">Belum ada laporan dari siswa</p>
                    </div>
                @endforelse
            </div>

        </main>
    </div>

    <!-- ==================== MODAL BALAS LAPORAN ==================== -->
    <div id="replyModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
        <div class="bg-white rounded-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto modal-pop">
            <div class="bg-gradient-to-r from-[#d97706] to-[#f59e0b] px-6 py-4 sticky top-0 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-2 rounded-full">
                            <i class="fas fa-reply-all text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-white text-xl font-bold">Balas Laporan</h3>
                            <p class="text-white/80 text-sm">Berikan tanggapan untuk siswa</p>
                        </div>
                    </div>
                    <button onclick="closeReplyModal()" class="text-white/80 hover:text-white text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <form id="replyForm" method="POST" class="p-6">
                @csrf
                <input type="hidden" id="laporanId" name="laporan_id">

                <div class="bg-amber-50 rounded-xl p-4 mb-5">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-amber-500"></i> Detail Laporan
                    </h4>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-500">Siswa:</span>
                            <p id="detailSiswa" class="font-medium text-gray-800">-</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Kategori:</span>
                            <p id="detailKategori" class="font-medium text-gray-800">-</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Lokasi:</span>
                            <p id="detailLokasi" class="font-medium text-gray-800">-</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Status:</span>
                            <p id="detailStatus" class="font-medium">-</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-gray-500 text-sm">Keterangan:</span>
                        <p id="detailKeterangan" class="text-gray-700 bg-white p-2 rounded-lg mt-1 text-sm">-</p>
                    </div>
                    <div id="detailFotoContainer" class="mt-3 hidden">
                        <span class="text-gray-500 text-sm">Foto Laporan:</span>
                        <img id="detailFoto" src="" alt="Foto"
                            class="w-32 h-32 object-cover rounded-lg mt-1 shadow-sm">
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm flex items-center gap-2">
                        <i class="fas fa-chart-line text-amber-500"></i> Update Status
                    </label>
                    <select name="status" id="statusSelect"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500">
                        <option value="Belum diproses">⏳ Belum diproses</option>
                        <option value="Menunggu Proses">⏳ Menunggu Proses</option>
                        <option value="Dalam Proses">⚙️ Dalam Proses</option>
                        <option value="Selesai">✅ Selesai</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm flex items-center gap-2">
                        <i class="fas fa-comment-dots text-amber-500"></i> Feedback / Tanggapan
                    </label>
                    <textarea name="feedback" id="feedbackText" rows="4"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 resize-none"
                        placeholder="Tulis tanggapan untuk siswa..."></textarea>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit"
                        class="flex-1 btn-primary text-white py-3 rounded-xl font-semibold flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Kirim Balasan
                    </button>
                    <button type="button" onclick="closeReplyModal()"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Chart Status
        const ctx = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Dalam Proses', 'Menunggu'],
                datasets: [{
                    data: [{{ $selesai }}, {{ $proses }}, {{ $pending }}],
                    backgroundColor: ['#22c55e', '#f59e0b', '#3b82f6'],
                    borderWidth: 0,
                    borderRadius: 10,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });

        // Search Filter
        const searchInput = document.getElementById('searchInput');
        const laporanCards = document.querySelectorAll('.laporan-card');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const keyword = this.value.toLowerCase();
                laporanCards.forEach(card => {
                    const searchText = card.getAttribute('data-search').toLowerCase();
                    card.style.display = searchText.includes(keyword) ? '' : 'none';
                });
            });
        }

        // Modal Reply Functions
        function openReplyModal(id, siswa, kategori, lokasi, keterangan, status, feedback, foto) {
            console.log("Opening modal for ID:", id);

            // Set form action
            document.getElementById('replyForm').action = '/update/status/' + id;
            document.getElementById('laporanId').value = id;

            // Set detail laporan
            document.getElementById('detailSiswa').innerText = siswa;
            document.getElementById('detailKategori').innerText = kategori;
            document.getElementById('detailLokasi').innerText = lokasi;
            document.getElementById('detailKeterangan').innerText = keterangan;

            // Set status select
            const statusSelect = document.getElementById('statusSelect');
            if (status == 'Selesai') statusSelect.value = 'Selesai';
            else if (status == 'Dalam Proses') statusSelect.value = 'Dalam Proses';
            else if (status == 'Menunggu Proses') statusSelect.value = 'Menunggu Proses';
            else statusSelect.value = 'Belum diproses';

            // Set status badge
            const detailStatus = document.getElementById('detailStatus');
            let statusBadgeClass = 'bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs inline-block';
            let statusIcon = 'fa-hourglass-half';
            if (status == 'Selesai') {
                statusBadgeClass = 'bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs inline-block';
                statusIcon = 'fa-check-circle';
            } else if (status == 'Dalam Proses') {
                statusBadgeClass = 'bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs inline-block';
                statusIcon = 'fa-spinner fa-pulse';
            } else if (status == 'Menunggu Proses') {
                statusBadgeClass = 'bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs inline-block';
                statusIcon = 'fa-clock';
            }
            detailStatus.innerHTML =
                `<span class="${statusBadgeClass}"><i class="fas ${statusIcon} mr-1"></i> ${status}</span>`;

            // Set feedback text
            const feedbackTextarea = document.getElementById('feedbackText');
            if (feedback && feedback != 'Belum ada feedback') {
                feedbackTextarea.value = feedback;
            } else {
                feedbackTextarea.value = '';
            }

            // Set foto jika ada
            const fotoContainer = document.getElementById('detailFotoContainer');
            const fotoImg = document.getElementById('detailFoto');
            if (foto && foto != '') {
                fotoImg.src = foto;
                fotoContainer.classList.remove('hidden');
            } else {
                fotoContainer.classList.add('hidden');
            }

            // Tampilkan modal
            document.getElementById('replyModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeReplyModal() {
            document.getElementById('replyModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal on backdrop click
        window.onclick = function(e) {
            const modal = document.getElementById('replyModal');
            if (e.target === modal) closeReplyModal();
        }

        // Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('replyModal').style.display === 'flex')
                closeReplyModal();
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
