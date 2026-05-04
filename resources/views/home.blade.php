<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth">

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
                    <a href="/laporan-publik" class="text-gray-600 hover:text-[#d97706] transition hidden md:block">
                        Lihat Laporan
                    </a>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 pt-1 relative">
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
                    </p>
                    <div class="flex flex-wrap gap-4 mt-8">
                        <a href="/laporan-publik"
                            class="border-2 bg-gradient-to-r from-[#d97706] to-[#f59e0b] text-white  px-8 py-3 rounded-xl font-semibold hover:text-white transition">
                            <i class="fas fa-eye mr-2"></i>Lihat Semua Laporan
                        </a>
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
                        <!-- FOTO SEKOLAH - DENGAN BORDER RADIUS BESAR -->
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                            <img src="{{ asset('images/gedung-skaju1.jpg') }}" alt="SMK Negeri 7 Batam"
                                class="w-full h-80 object-cover">
                            <div class="absolute inset-0 bg-black/20 flex items-end justify-center pb-4">
                                <p class="text-white font-semibold text-lg drop-shadow-md">SMK Negeri 7 Batam</p>
                            </div>
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
                    <h3 class="text-xl font-bold mb-2">Login</h3>
                    <p class="text-white/80">Masuk menggunakan NIS dan password yang telah di daftarkan oleh admin</p>
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
                        <span class="text-gray-600"> Komp. Koperasi Pemko, Batam centre, Belian, Kec. Batam Kota, Kota
                            Batam, Kepulauan Riau, Indonesia</span>
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
                            <div class="font-bold">Pirfir</div>
                            <div class="text-xs text-gray-500">Kelas XI RPL 2</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Cepat banget responnya! Cuma 2 jam setelah laporan AC rusak, langsung
                        diganti dengan yang baru. Mantap!"</p>
                    <div class="flex text-yellow-400 mt-3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-amber-100 w-12 h-12 rounded-full flex items-center justify-center"><i
                                class="fas fa-user-graduate text-amber-600"></i></div>
                        <div>
                            <div class="font-bold">dyfir</div>
                            <div class="text-xs text-gray-500">Kelas XI RPL 1</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Aplikasi sangat membantu! Sekarang saya bisa lapor kerusakan tanpa harus
                        ke kantor."</p>
                    <div class="flex text-yellow-400 mt-3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-amber-100 w-12 h-12 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-graduate text-amber-600"></i>
                        </div>
                        <div>
                            <div class="font-bold">Prifyy</div>
                            <div class="text-xs text-gray-500">Kelas XI RPL 4</div>
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
                <form action="/login-siswa" method="POST" id="loginSiswaForm">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">NIS</label>
                        <div class="relative">
                            <input type="text" name="nis" id="nisInput" placeholder="Masukkan NIS (8 digit)"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 transition-all"
                                maxlength="8" oninput="validateNIS(this)">
                            <!-- Indikator warna -->
                            <div id="nisIndicator"
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-gray-300">
                            </div>
                        </div>
                        <!-- Counter karakter -->
                        <div class="flex justify-between items-center mt-1">
                            <p id="nisStatus" class="text-xs text-gray-400">NIS terdiri dari 8 digit angka</p>
                            <p id="nisCounter" class="text-xs font-mono text-gray-400">0/8</p>
                        </div>
                        @error('nis')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="loginPassword"
                                placeholder="Masukkan Password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 pr-10">
                            <button type="button" onclick="togglePassword('loginPassword', 'loginEyeIcon')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-amber-500">
                                <i id="loginEyeIcon" class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" id="loginSubmitBtn"
                        class="w-full bg-gradient-to-r from-[#d97706] to-[#f59e0b] text-white py-2 rounded-xl font-semibold opacity-50 cursor-not-allowed transition">
                        Login
                    </button>
                </form>
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
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="adminPassword" placeholder="Password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 pr-10">
                        <button type="button" onclick="togglePassword('adminPassword', 'adminEyeIcon')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-amber-500">
                            <i id="adminEyeIcon" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-gray-700 to-gray-900 text-white py-2 rounded-xl font-semibold hover:from-gray-800 hover:to-gray-950 transition">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>
            </form>
        </div>
    </div>

    <!-- Tombol Back to Top -->
    <div class="back-to-top" id="backToTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <i class="fas fa-arrow-up text-xl"></i>
    </div>

    <!-- ==================== SCRIPT ==================== -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 600
        });

        // Back to Top - muncul saat scroll
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
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

        // ============ VALIDASI NIS (MAKSIMAL 8 DIGIT) ============
        function validateNIS(input) {
            // Hanya izinkan angka
            input.value = input.value.replace(/[^0-9]/g, '');

            const nisValue = input.value;
            const nisLength = nisValue.length;
            const indicator = document.getElementById('nisIndicator');
            const counter = document.getElementById('nisCounter');
            const statusText = document.getElementById('nisStatus');
            const submitBtn = document.getElementById('loginSubmitBtn');

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

        // Panggil validasi saat halaman dimuat (untuk input yang sudah terisi)
        document.addEventListener('DOMContentLoaded', function() {
            const nisInput = document.getElementById('nisInput');
            if (nisInput && nisInput.value) {
                validateNIS(nisInput);
            }
        });

        // ============ TOGGLE PASSWORD ============
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
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
