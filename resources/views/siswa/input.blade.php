<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Kirim Pengaduan | SIPASSA SMK N 7 Batam</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 50%, #fde68a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .animate-card {
            animation: fadeSlideUp 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(245,158,11,0.5);
        }
        
        .preview-image {
            max-width: 100%;
            max-height: 150px;
            border-radius: 10px;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <div class="max-w-2xl w-full mx-auto animate-card">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-amber-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#d97706] to-[#f59e0b] px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 backdrop-blur-sm p-2.5 rounded-xl">
                        <i class="fas fa-pen-ruler text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-white text-2xl font-bold tracking-tight">Kirim Pengaduan</h2>
                        <p class="text-white/80 text-sm mt-0.5">Laporkan kerusakan sarana sekolah</p>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <form action="/input-aspirasi" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
                @csrf
                
                <!-- Kategori -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm flex items-center gap-2">
                        <i class="fas fa-tag text-[#d97706]"></i> 
                        Kategori Kerusakan
                    </label>
                    <select name="id_kategori" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#f59e0b]">
                        <option value="" disabled selected>Pilih kategori kerusakan</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id_kategori }}">{{ $k->ket_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Lokasi -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm flex items-center gap-2">
                        <i class="fas fa-location-dot text-[#d97706]"></i> 
                        Lokasi
                    </label>
                    <input type="text" name="lokasi" required placeholder="Contoh: Ruang 203, Lab Komputer, Kantin" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#f59e0b]">
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="text-xs bg-amber-100 text-amber-700 px-3 py-1.5 rounded-full cursor-pointer" onclick="setLokasi('Ruang Kelas 101')">🏫 Ruang 101</span>
                        <span class="text-xs bg-amber-100 text-amber-700 px-3 py-1.5 rounded-full cursor-pointer" onclick="setLokasi('Lab. Komputer')">💻 Lab Komputer</span>
                        <span class="text-xs bg-amber-100 text-amber-700 px-3 py-1.5 rounded-full cursor-pointer" onclick="setLokasi('Toilet Utama')">🚽 Toilet</span>
                        <span class="text-xs bg-amber-100 text-amber-700 px-3 py-1.5 rounded-full cursor-pointer" onclick="setLokasi('Kantin')">🍽️ Kantin</span>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm flex items-center gap-2">
                        <i class="fas fa-align-left text-[#d97706]"></i> 
                        Keterangan Detail
                    </label>
                    <textarea name="ket" rows="4" required placeholder="Jelaskan kerusakan yang terjadi secara jelas..." 
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#f59e0b] resize-none"></textarea>
                </div>

                <!-- UPLOAD FOTO BARU -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm flex items-center gap-2">
                        <i class="fas fa-camera text-[#d97706]"></i> 
                        Foto Kerusakan (Opsional)
                    </label>
                    
                    <!-- Preview Foto -->
                    <div id="previewContainer" class="hidden mb-3">
                        <p class="text-xs text-gray-500 mb-2">Preview Foto:</p>
                        <img id="imagePreview" class="preview-image border rounded-lg shadow-sm">
                        <button type="button" onclick="removeImage()" class="text-xs text-red-500 mt-1 hover:underline">Hapus Foto</button>
                    </div>
                    
                    <!-- Input File -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-[#f59e0b] transition cursor-pointer" onclick="document.getElementById('fotoInput').click()">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-500">Klik untuk upload foto</p>
                        <p class="text-xs text-gray-400">Maksimal 2MB (JPG, PNG)</p>
                        <input type="file" id="fotoInput" name="foto" class="hidden" accept="image/jpeg,image/jpg,image/png" onchange="previewImage(this)">
                    </div>
                </div>

                <!-- Tombol -->
                <div class="flex flex-col sm:flex-row gap-3 mt-8">
                    <button type="submit" class="flex-1 btn-primary text-white font-bold py-3 rounded-xl shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Kirim Pengaduan
                    </button>
                    <a href="/dashboard-siswa" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 rounded-xl transition flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>

            <!-- Footer -->
            <div class="bg-amber-50 px-6 py-4 border-t border-amber-100 text-xs text-gray-600 flex justify-between">
                <span><i class="fas fa-shield-alt text-amber-600"></i> Data aman</span>
                <span><i class="fas fa-clock text-amber-600"></i> Respon 2x24 jam</span>
                <span><i class="fas fa-image text-amber-600"></i> Foto membantu mempercepat</span>
            </div>
        </div>
    </div>

    <script>
        function setLokasi(locationName) {
            document.querySelector('input[name="lokasi"]').value = locationName;
        }
        
        function previewImage(input) {
            const previewContainer = document.getElementById('previewContainer');
            const imagePreview = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function removeImage() {
            const fileInput = document.getElementById('fotoInput');
            const previewContainer = document.getElementById('previewContainer');
            fileInput.value = '';
            previewContainer.classList.add('hidden');
        }
    </script>
</body>
</html>