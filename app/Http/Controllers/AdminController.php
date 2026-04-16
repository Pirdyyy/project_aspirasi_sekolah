<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Admin;
use App\Models\Siswa;

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
        $laporanSelesai = InputAspirasi::whereHas('aspirasi', function($q) {
            $q->where('status', 'Selesai');
        })->count();
        $laporanMenunggu = InputAspirasi::whereDoesntHave('aspirasi')
            ->orWhereHas('aspirasi', function($q) {
                $q->where('status', '!=', 'Selesai');
                $q->where('status', '!=', 'Dalam Proses');
            })->count();
        
        return view('admin.dashboard', compact('data', 'kategori', 'admin', 'totalKategori', 'totalSiswa', 'totalLaporan', 'laporanSelesai', 'laporanMenunggu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'feedback' => 'nullable|string'
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
}