<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>SIPASSA | Sistem Pengaduan Sarana SMK N 7 Batam</title>

    <!-- Tailwind CSS + Font Awesome + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

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

        .hero-gradient {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 35px -12px rgba(245, 158, 11, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(245, 158, 11, 0.5);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .float-animation {
            animation: float 4s ease-in-out infinite;
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

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #d97706, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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

    @php
        use App\Models\InputAspirasi;
        use App\Models\Siswa;
        use App\Models\Kategori;

        // Ambil data statistik REAL dari database
        $totalLaporan = InputAspirasi::count();
        $totalSiswa = Siswa::count();
        $totalKategori = Kategori::count();
        $laporanSelesai = InputAspirasi::whereHas('aspirasi', function ($q) {
            $q->where('status', 'Selesai');
        })->count();

        // Hitung persentase penyelesaian
        $persentaseSelesai = $totalLaporan > 0 ? round(($laporanSelesai / $totalLaporan) * 100) : 0;

        // Hitung laporan dalam proses
        $laporanProses = InputAspirasi::whereHas('aspirasi', function ($q) {
            $q->where('status', 'Dalam Proses');
        })->count();

        // Hitung laporan menunggu
        $laporanMenunggu = $totalLaporan - ($laporanSelesai + $laporanProses);
    @endphp

    <!-- ==================== NAVIGASI BAR ==================== -->
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
                    <a href="#fitur" class="text-gray-600 hover:text-[#d97706] transition hidden md:block">Fitur</a>
                    <a href="#tentang" class="text-gray-600 hover:text-[#d97706] transition hidden md:block">Tentang</a>
                    <a href="#kontak" class="text-gray-600 hover:text-[#d97706] transition hidden md:block">Kontak</a>
                    <button onclick="openRole()"
                        class="bg-gradient-to-r from-[#d97706] to-[#f59e0b] text-white px-5 py-2 rounded-xl font-semibold btn-primary shadow-md">
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- ==================== HERO SECTION ==================== -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-amber-50 via-white to-yellow-50 opacity-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right" data-aos-duration="800">
                    <div
                        class="inline-flex items-center gap-2 bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-sm mb-4">
                        <i class="fas fa-check-circle"></i>
                        <span>Respon Cepat • Transparan</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight">
                        <span class="gradient-text">Sistem Pengaduan</span><br>
                        Sarana Sekolah
                    </h1>
                    <p class="text-gray-600 text-lg mt-4 leading-relaxed">
                        Laporkan kerusakan fasilitas sekolah dengan mudah, cepat, dan terintegrasi.
                        Setiap laporan akan kami tindak lanjuti maksimal 2x24 jam.
                    </p>
                    <div class="flex flex-wrap gap-4 mt-8">
                        <button onclick="openRole()"
                            class="bg-gradient-to-r from-[#d97706] to-[#f59e0b] text-white px-8 py-3 rounded-xl font-bold btn-primary shadow-lg">
                            <i class="fas fa-pen-ruler mr-2"></i>Laporkan Sekarang
                        </button>
                        <a href="#fitur"
                            class="border-2 border-[#f59e0b] text-[#d97706] px-8 py-3 rounded-xl font-semibold hover:bg-[#f59e0b] hover:text-white transition">
                            <i class="fas fa-play mr-2"></i>Lihat Fitur
                        </a>
                    </div>
                    <div class="flex items-center gap-6 mt-8 pt-4 border-t border-gray-200">
                        <div class="text-center">
                            <div class="stat-number">{{ $totalLaporan }}</div>
                            <div class="text-xs text-gray-500">Laporan Masuk</div>
                        </div>
                        <div class="text-center">
                            <div class="stat-number">{{ $persentaseSelesai }}%</div>
                            <div class="text-xs text-gray-500">Terselesaikan</div>
                        </div>
                        <div class="text-center">
                            <div class="stat-number">24/7</div>
                            <div class="text-xs text-gray-500">Layanan Aktif</div>
                        </div>
                    </div>
                </div>
                <div class="relative" data-aos="fade-left" data-aos-duration="800">
                    <div class="float-animation">
                        <div
                            class="bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl shadow-2xl p-8 text-center">
                            <i class="fas fa-clipboard-list text-white text-8xl"></i>
                            <p class="text-white mt-4 font-semibold">Sistem Pengaduan Online</p>
                        </div>
                    </div>
                    <div class="absolute -bottom-5 -left-5 bg-white rounded-xl shadow-lg p-3 flex items-center gap-3">
                        <div class="bg-amber-100 p-2 rounded-full"><i class="fas fa-check-circle text-amber-500"></i>
                        </div>
                        <div>
                            <div class="font-bold">Respon Cepat</div>
                            <div class="text-xs text-gray-500">Rata-rata 1 jam</div>
                        </div>
                    </div>
                    <div class="absolute -top-5 -right-5 bg-white rounded-xl shadow-lg p-3 flex items-center gap-3">
                        <div class="bg-amber-100 p-2 rounded-full"><i class="fas fa-chart-line text-amber-500"></i>
                        </div>
                        <div>
                            <div class="font-bold">100% Transparan</div>
                            <div class="text-xs text-gray-500">Status realtime</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== STATISTIK DINAMIS DARI DATABASE ==================== -->
    <section class="bg-white py-12 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div data-aos="zoom-in" data-aos-delay="0">
                    <div class="bg-amber-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-building text-2xl text-[#d97706]"></i>
                    </div>
                    <div class="text-2xl font-bold text-gray-800">{{ $totalKategori }}</div>
                    <div class="text-sm text-gray-500">Kategori Sarana</div>
                </div>
                <div data-aos="zoom-in" data-aos-delay="100">
                    <div class="bg-amber-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-users text-2xl text-[#d97706]"></i>
                    </div>
                    <div class="text-2xl font-bold text-gray-800">{{ $totalSiswa }}</div>
                    <div class="text-sm text-gray-500">Siswa Terdaftar</div>
                </div>
                <div data-aos="zoom-in" data-aos-delay="200">
                    <div class="bg-amber-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-check-circle text-2xl text-[#d97706]"></i>
                    </div>
                    <div class="text-2xl font-bold text-gray-800">{{ $laporanSelesai }}</div>
                    <div class="text-sm text-gray-500">Laporan Selesai</div>
                </div>
                <div data-aos="zoom-in" data-aos-delay="300">
                    <div class="bg-amber-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-clock text-2xl text-[#d97706]"></i>
                    </div>
                    <div class="text-2xl font-bold text-gray-800">{{ $laporanMenunggu }}</div>
                    <div class="text-sm text-gray-500">Menunggu Respon</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FITUR UNGGULAN ==================== -->
    <section id="fitur" class="py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <div
                    class="inline-flex items-center gap-2 bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-sm mb-3">
                    <i class="fas fa-star"></i>
                    <span>Fitur Unggulan</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Kenapa Harus <span
                        class="gradient-text">SIPASSA?</span></h2>
                <p class="text-gray-500 mt-3 max-w-2xl mx-auto">Kami hadir untuk memudahkan Anda melaporkan kerusakan
                    fasilitas sekolah</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-6 shadow-lg card-hover" data-aos="fade-up" data-aos-delay="0">
                    <div class="bg-amber-100 w-14 h-14 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-mobile-alt text-2xl text-[#d97706]"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Mudah Digunakan</h3>
                    <p class="text-gray-500">Cukup login, pilih kategori, isi lokasi dan deskripsi. Semua bisa
                        dilakukan dalam 2 menit!</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-amber-100 w-14 h-14 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-2xl text-[#d97706]"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Pantau Status</h3>
                    <p class="text-gray-500">Lihat perkembangan laporan Anda secara realtime, dari diterima hingga
                        selesai.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-amber-100 w-14 h-14 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-comment-dots text-2xl text-[#d97706]"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Feedback Langsung</h3>
                    <p class="text-gray-500">Admin akan memberikan feedback dan solusi atas setiap laporan yang masuk.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== CARA KERJA ==================== -->
    <section class="hero-gradient py-16 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold">Bagaimana Cara Kerjanya?</h2>
                <p class="text-white/80 mt-3">Ikuti 3 langkah mudah berikut</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center" data-aos="fade-up" data-aos-delay="0">
                    <div
                        class="bg-white/20 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold">
                        1</div>
                    <h3 class="text-xl font-bold mb-2">Login / Register</h3>
                    <p class="text-white/80">Masuk menggunakan NIS dan password, atau daftar jika belum punya akun.</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="bg-white/20 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold">
                        2</div>
                    <h3 class="text-xl font-bold mb-2">Buat Laporan</h3>
                    <p class="text-white/80">Isi kategori, lokasi, dan deskripsi kerusakan dengan detail.</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="bg-white/20 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold">
                        3</div>
                    <h3 class="text-xl font-bold mb-2">Pantau & Selesai</h3>
                    <p class="text-white/80">Lihat status laporan dan dapatkan feedback dari admin.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== TENTANG ==================== -->
    <section id="tentang" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right">
                    <div class="bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl shadow-xl p-8 text-center">
                        <img src="{{ asset('images/gedung-skaju1.jpg') }}" alt="Gedung SMK Negeri 7 Batam"
                            class="w-full h-48 object-cover rounded-lg">
                        <p class="text-white mt-4 font-semibold">SMK Negeri 7 Batam</p>
                    </div>
                </div>
                <div data-aos="fade-left">
                    <div
                        class="inline-flex items-center gap-2 bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-sm mb-3">
                        <i class="fas fa-info-circle"></i>
                        <span>Tentang Kami</span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">SMK Negeri 7 Batam</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        SMK Negeri 7 Batam adalah sekolah menengah kejuruan yang berkomitmen memberikan pendidikan
                        berkualitas
                        dengan fasilitas yang memadai. Kami hadirkan sistem pengaduan sarana untuk memastikan setiap
                        kerusakan fasilitas dapat segera ditangani.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Dengan SIPASSA, kami ingin mendengar suara siswa dan menciptakan lingkungan belajar yang nyaman
                        serta aman bagi seluruh warga sekolah.
                    </p>
                    <div class="flex items-center gap-4 mt-6">
                        <i class="fas fa-map-marker-alt text-[#d97706]"></i>
                        <span class="text-gray-600">Jl. Pendidikan No. 123, Batam, Kepulauan Riau</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== TESTIMONIAL ==================== -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-gray-800">Apa Kata <span class="gradient-text">Mereka?</span></h2>
                <p class="text-gray-500 mt-2">Testimoni dari pengguna SIPASSA</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-lg card-hover" data-aos="fade-up" data-aos-delay="0">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-amber-100 w-12 h-12 rounded-full flex items-center justify-center"><i
                                class="fas fa-user-graduate text-amber-600"></i></div>
                        <div>
                            <div class="font-bold">Ahmad Rizki</div>
                            <div class="text-xs text-gray-500">Kelas XII RPL</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Cepat banget responnya! Cuma 2 jam setelah laporan AC rusak, langsung
                        diperbaiki. Mantap!"</p>
                    <div class="flex text-yellow-400 mt-3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-amber-100 w-12 h-12 rounded-full flex items-center justify-center"><i
                                class="fas fa-user-graduate text-amber-600"></i></div>
                        <div>
                            <div class="font-bold">Siti Nurhaliza</div>
                            <div class="text-xs text-gray-500">Kelas XI AKL</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Aplikasi sangat membantu! Sekarang saya bisa lapor kerusakan tanpa harus
                        ke kantor."</p>
                    <div class="flex text-yellow-400 mt-3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-amber-100 w-12 h-12 rounded-full flex items-center justify-center"><i
                                class="fas fa-chalkboard-user text-amber-600"></i></div>
                        <div>
                            <div class="font-bold">Bpk. Darmawan</div>
                            <div class="text-xs text-gray-500">Guru</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Sistem ini memudahkan monitoring sarana sekolah. Transparan dan
                        akuntabel!"</p>
                    <div class="flex text-yellow-400 mt-3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== KONTAK & CTA ==================== -->
    <section id="kontak" class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Siap Melaporkan Kerusakan?</h2>
            <p class="text-gray-500 mb-8">Bergabunglah dengan ribuan siswa lainnya yang sudah menggunakan SIPASSA</p>
            <button onclick="openRole()"
                class="bg-gradient-to-r from-[#d97706] to-[#f59e0b] text-white px-10 py-4 rounded-xl font-bold text-lg btn-primary shadow-xl">
                <i class="fas fa-paper-plane mr-2"></i>Mulai Laporkan Sekarang
            </button>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center gap-6 mb-4">
                <a href="#" class="hover:text-[#f59e0b] transition"><i
                        class="fab fa-instagram text-xl"></i></a>
                <a href="#" class="hover:text-[#f59e0b] transition"><i class="fab fa-facebook text-xl"></i></a>
                <a href="#" class="hover:text-[#f59e0b] transition"><i class="fab fa-twitter text-xl"></i></a>
                <a href="#" class="hover:text-[#f59e0b] transition"><i class="fab fa-youtube text-xl"></i></a>
            </div>
            <p class="text-gray-400 text-sm">&copy; 2024 SIPASSA - SMK Negeri 7 Batam. All rights reserved.</p>
            <p class="text-gray-500 text-xs mt-2">Sistem Pengaduan Sarana Sekolah | Respon Cepat & Transparan</p>
        </div>
    </footer>

    <!-- ==================== MODAL PILIH ROLE ==================== -->
    <div id="roleModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
        <div class="bg-white rounded-2xl max-w-sm w-full mx-4 p-6 text-center modal-pop">
            <div class="hero-gradient -mt-6 -mx-6 px-6 py-4 rounded-t-2xl">
                <h3 class="text-white text-xl font-bold">Pilih Role Login</h3>
            </div>
            <div class="py-6">
                <button onclick="openSiswa()"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-xl font-semibold transition mb-3">
                    <i class="fas fa-user-graduate mr-2"></i>Login sebagai Siswa
                </button>
                <button onclick="openAdmin()"
                    class="w-full bg-gray-700 hover:bg-gray-800 text-white py-3 rounded-xl font-semibold transition">
                    <i class="fas fa-user-shield mr-2"></i>Login sebagai Admin
                </button>
            </div>
            <button onclick="closeRole()" class="text-gray-400 hover:text-gray-600 text-sm">Tutup</button>
        </div>
    </div>

    <!-- ==================== MODAL SISWA ==================== -->
    <div id="siswaModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6 modal-pop">
            <div class="flex justify-between items-center mb-4 border-b pb-3">
                <h3 class="text-xl font-bold gradient-text"><i class="fas fa-user-graduate mr-2"></i>Siswa</h3>
                <button onclick="closeSiswa()" class="text-gray-400 hover:text-gray-600"><i
                        class="fas fa-times text-xl"></i></button>
            </div>

            <!-- LOGIN FORM -->
            <div id="loginForm">
                <form action="/login-siswa" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">NIS</label>
                        <input type="text" name="nis" placeholder="Masukkan NIS"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <input type="password" name="password" placeholder="Masukkan Password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#d97706] to-[#f59e0b] text-white py-2 rounded-xl font-semibold">Login</button>
                </form>
                <p class="text-center text-sm text-gray-500 mt-4">
                    Belum punya akun?
                    <a href="#" onclick="showRegister()" class="text-[#d97706] font-semibold">Register di
                        sini!</a>
                </p>
            </div>

            <!-- REGISTER FORM -->
            <div id="registerForm" style="display:none;">
                <form action="/register" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="nis" placeholder="NIS"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="nama" placeholder="Nama Lengkap"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="kelas" placeholder="Kelas (contoh: XII RPL 1)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" placeholder="Password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                    </div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#d97706] to-[#f59e0b] text-white py-2 rounded-xl font-semibold">Daftar</button>
                </form>
                <p class="text-center text-sm text-gray-500 mt-4">
                    Sudah punya akun?
                    <a href="#" onclick="showLogin()" class="text-[#d97706] font-semibold">Login di sini!</a>
                </p>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL ADMIN ==================== -->
    <div id="adminModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 modal-backdrop hidden">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6 modal-pop">
            <div class="flex justify-between items-center mb-4 border-b pb-3">
                <h3 class="text-xl font-bold gradient-text"><i class="fas fa-user-shield mr-2"></i>Admin</h3>
                <button onclick="closeAdmin()" class="text-gray-400 hover:text-gray-600"><i
                        class="fas fa-times text-xl"></i></button>
            </div>
            <form action="/login-admin" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input type="text" name="username" placeholder="Username"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" placeholder="Password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-gray-700 to-gray-900 text-white py-2 rounded-xl font-semibold">Login</button>
            </form>
        </div>
    </div>

    <!-- ==================== SCRIPT ==================== -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 600
        });

        // Role Modal
        function openRole() {
            document.getElementById("roleModal").style.display = "flex";
            document.body.style.overflow = "hidden";
        }

        function closeRole() {
            document.getElementById("roleModal").style.display = "none";
            document.body.style.overflow = "auto";
        }

        // Siswa Modal
        function openSiswa() {
            closeRole();
            document.getElementById("siswaModal").style.display = "flex";
            document.body.style.overflow = "hidden";
        }

        function closeSiswa() {
            document.getElementById("siswaModal").style.display = "none";
            document.body.style.overflow = "auto";
        }

        // Admin Modal
        function openAdmin() {
            closeRole();
            document.getElementById("adminModal").style.display = "flex";
            document.body.style.overflow = "hidden";
        }

        function closeAdmin() {
            document.getElementById("adminModal").style.display = "none";
            document.body.style.overflow = "auto";
        }

        // Toggle Register/Login
        function showRegister() {
            document.getElementById("loginForm").style.display = "none";
            document.getElementById("registerForm").style.display = "block";
        }

        function showLogin() {
            document.getElementById("loginForm").style.display = "block";
            document.getElementById("registerForm").style.display = "none";
        }

        // Close modal when clicking outside
        window.onclick = function(e) {
            const roleModal = document.getElementById("roleModal");
            const siswaModal = document.getElementById("siswaModal");
            const adminModal = document.getElementById("adminModal");
            if (e.target === roleModal) closeRole();
            if (e.target === siswaModal) closeSiswa();
            if (e.target === adminModal) closeAdmin();
        }
    </script>

    @if (session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button onclick="this.parentElement.remove()" class="ml-3"><i class="fas fa-times"></i></button>
        </div>
    @endif

    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button onclick="this.parentElement.remove()" class="ml-3"><i class="fas fa-times"></i></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50">
            @foreach ($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle mr-2"></i> {{ $error }}</div>
            @endforeach
            <button onclick="this.parentElement.remove()" class="mt-2 text-sm hover:underline">Tutup</button>
        </div>
    @endif

</body>

</html>
