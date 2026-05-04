<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Admin;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Ambil semua data laporan
        $data = InputAspirasi::with(['siswa', 'kategori', 'aspirasi'])
            ->orderBy('id_pelaporan', 'desc')
            ->get();

        // Ambil semua kategori
        $kategori = Kategori::all();

        // Ambil data admin yang sedang login
        $admin = Admin::where('username', session('admin'))->first();

        // Data statistik untuk dashboard
        $totalKategori = Kategori::count();
        $totalSiswa = Siswa::count();
        $totalLaporan = InputAspirasi::count();
        $laporanSelesai = InputAspirasi::whereHas('aspirasi', function ($q) {
            $q->where('status', 'Selesai');
        })->count();
        $laporanMenunggu = InputAspirasi::whereDoesntHave('aspirasi')
            ->orWhereHas('aspirasi', function ($q) {
                $q->where('status', '!=', 'Selesai');
                $q->where('status', '!=', 'Dalam Proses');
            })->count();

        // Ambil semua siswa untuk dropdown filter
        $allSiswa = Siswa::orderBy('nama', 'asc')->get();

        return view('admin.dashboard', compact('data', 'kategori', 'admin', 'totalKategori', 'totalSiswa', 'totalLaporan', 'laporanSelesai', 'laporanMenunggu', 'allSiswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'feedback' => 'nullable|string|max:5000'
        ]);

        $cek = Aspirasi::where('id_pelaporan', $id)->first();

        if ($cek) {
            $cek->update([
                'status' => $request->status,
                'feedback' => $request->feedback
            ]);
        } else {
            Aspirasi::create([
                'id_pelaporan' => $id,
                'username' => session('admin'),
                'status' => $request->status,
                'feedback' => $request->feedback
            ]);
        }

        // Jika request dari AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Status dan feedback berhasil diupdate!']);
        }

        return back()->with('success', 'Status dan feedback berhasil diupdate!');
    }

    public function delete($id)
    {
        Aspirasi::where('id_pelaporan', $id)->delete();

        $laporan = InputAspirasi::where('id_pelaporan', $id)->first();
        if ($laporan && $laporan->foto && file_exists(public_path($laporan->foto))) {
            unlink(public_path($laporan->foto));
        }

        InputAspirasi::where('id_pelaporan', $id)->delete();

        // Jika request dari AJAX
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Laporan berhasil dihapus!']);
        }

        return back()->with('success', 'Laporan berhasil dihapus!');
    }

    public function tambahKategori(Request $request)
    {
        $request->validate([
            'ket_kategori' => 'required|unique:kategori,ket_kategori'
        ]);

        Kategori::create([
            'ket_kategori' => $request->ket_kategori
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function editKategori(Request $request, $id)
    {
        $request->validate([
            'ket_kategori' => 'required|unique:kategori,ket_kategori,' . $id . ',id_kategori'
        ]);

        Kategori::where('id_kategori', $id)->update([
            'ket_kategori' => $request->ket_kategori
        ]);

        return back()->with('success', 'Kategori berhasil diupdate!');
    }

    public function hapusKategori($id)
    {
        $cek = InputAspirasi::where('id_kategori', $id)->exists();

        if ($cek) {
            return back()->with('error', 'Kategori sedang digunakan oleh laporan!');
        }

        Kategori::where('id_kategori', $id)->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }

    public function statistik()
    {
        $data = InputAspirasi::with(['siswa', 'kategori', 'aspirasi'])->get();
        $admin = Admin::where('username', session('admin'))->first();

        return view('admin.statistik', compact('data', 'admin'));
    }

    public function kategoriPage()
    {
        $kategori = Kategori::all();
        $admin = Admin::where('username', session('admin'))->first();

        return view('admin.kategori', compact('kategori', 'admin'));
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data dipilih']);
        }

        foreach ($ids as $id) {
            // Hapus aspirasi dulu
            Aspirasi::where('id_pelaporan', $id)->delete();

            // Hapus file foto
            $laporan = InputAspirasi::where('id_pelaporan', $id)->first();
            if ($laporan && $laporan->foto && file_exists(public_path($laporan->foto))) {
                unlink(public_path($laporan->foto));
            }

            // Hapus laporan
            InputAspirasi::where('id_pelaporan', $id)->delete();
        }

        return response()->json(['success' => true]);
    }

    // Method untuk menampilkan form registrasi siswa
    public function registrasiSiswaForm()
    {
        $siswaList = Siswa::orderBy('nis', 'desc')->get();
        $totalSiswa = Siswa::count();
        $sudahLogin = Siswa::whereNotNull('last_login')->count();
        $belumLogin = $totalSiswa - $sudahLogin;
        $totalLaporan = InputAspirasi::count(); // Tambahkan untuk statistik
        $admin = Admin::where('username', session('admin'))->first();

        return view('admin.registrasi-siswa', compact('siswaList', 'admin', 'totalSiswa', 'sudahLogin', 'belumLogin', 'totalLaporan'));
    }

    // Menyimpan registrasi siswa
    public function registrasiSiswaStore(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama' => 'required',
            'kelas' => 'required',
        ], [
            'nis.unique' => 'NIS sudah terdaftar! Gagal menambahkan siswa.'
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'password' => Hash::make('12345678')
        ]);

        // KEMBALI KE HALAMAN KELOLA SISWA, BUKAN DASHBOARD
        return redirect('/admin/kelola-siswa')->with('success', 'Siswa berhasil didaftarkan! Password default: 12345678');
    }

    // Reset password siswa
    public function resetPasswordSiswa($nis)
    {
        $siswa = Siswa::where('nis', $nis)->first();

        if (!$siswa) {
            return back()->with('error', 'Siswa tidak ditemukan!');
        }

        $siswa->update([
            'password' => Hash::make('12345678')
        ]);

        return back()->with('success', 'Password siswa ' . $siswa->nama . ' berhasil direset menjadi 12345678');
    }

    // Method untuk halaman kelola siswa
    public function kelolaSiswa()
    {
        $siswaList = Siswa::with('aspirasi')->orderBy('nama', 'asc')->get();
        $totalSiswa = Siswa::count();
        $totalLaporan = InputAspirasi::count();
        $siswaAktif = Siswa::whereNotNull('last_login')->count(); // <-- TAMBAHKAN INI
        $admin = Admin::where('username', session('admin'))->first();

        return view('admin.kelola-siswa', compact('siswaList', 'admin', 'totalSiswa', 'totalLaporan', 'siswaAktif'));
    }

    // Method untuk mendapatkan laporan siswa via AJAX
    public function getSiswaLaporan($nis)
    {
        $siswa = Siswa::where('nis', $nis)->first();

        if (!$siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        $laporan = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('nis', $nis)
            ->orderBy('id_pelaporan', 'desc')
            ->get();

        $total = $laporan->count();
        $selesai = 0;
        $proses = 0;
        $menunggu = 0;

        $laporanData = [];
        foreach ($laporan as $l) {
            $status = $l->aspirasi->status ?? 'Belum diproses';
            if ($status == 'Selesai') $selesai++;
            elseif ($status == 'Dalam Proses') $proses++;
            else $menunggu++;

            $laporanData[] = [
                'id' => $l->id_pelaporan,
                'kategori' => $l->kategori->ket_kategori ?? 'Umum',
                'lokasi' => $l->lokasi,
                'keterangan' => $l->ket,
                'status' => $status,
                'feedback' => $l->aspirasi->feedback ?? null,
                'foto' => $l->foto,
                'tanggal' => $l->created_at ? date('d/m/Y H:i', strtotime($l->created_at)) : '-'
            ];
        }

        return response()->json([
            'total' => $total,
            'selesai' => $selesai,
            'proses' => $proses,
            'menunggu' => $menunggu,
            'laporan' => $laporanData
        ]);
    }

    // Method untuk halaman laporan siswa (redirect ke halaman terpisah)
    public function laporanSiswa($nis)
    {
        $siswa = Siswa::where('nis', $nis)->first();

        if (!$siswa) {
            return redirect('/admin/kelola-siswa')->with('error', 'Siswa tidak ditemukan!');
        }

        $data = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('nis', $nis)
            ->orderBy('id_pelaporan', 'desc')
            ->get();

        $totalLaporan = $data->count();
        $admin = Admin::where('username', session('admin'))->first();

        return view('admin.laporan-siswa', compact('siswa', 'data', 'totalLaporan', 'admin'));
    }

    // Edit kelas siswa
    public function editKelasSiswa(Request $request, $nis)
    {
        $request->validate([
            'kelas' => 'required'
        ]);

        $siswa = Siswa::where('nis', $nis)->first();

        if (!$siswa) {
            return back()->with('error', 'Siswa tidak ditemukan!');
        }

        $siswa->update([
            'kelas' => $request->kelas
        ]);

        return back()->with('success', 'Kelas siswa berhasil diupdate!');
    }

    // Hapus siswa (hanya jika tidak memiliki laporan)
    public function hapusSiswa($nis)
    {
        $siswa = Siswa::where('nis', $nis)->first();

        if (!$siswa) {
            return back()->with('error', 'Siswa tidak ditemukan!');
        }

        $jmlLaporan = InputAspirasi::where('nis', $nis)->count();

        if ($jmlLaporan > 0) {
            return back()->with('error', 'Siswa memiliki ' . $jmlLaporan . ' laporan! Hapus laporan terlebih dahulu.');
        }

        $siswa->delete();

        return back()->with('success', 'Akun siswa ' . $siswa->nama . ' berhasil dihapus!');
    }

    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:4|confirmed',
        ]);

        $admin = Admin::where('username', session('admin'))->first();

        if ($admin->password != $request->password_lama) {
            return back()->with('error', 'Password lama yang Anda masukkan salah!');
        }

        $admin->update([
            'password' => $request->password_baru
        ]);

        return redirect('/dashboard-admin')->with('success', 'Password berhasil diubah!');
    }
}
