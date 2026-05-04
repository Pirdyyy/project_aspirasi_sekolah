<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Admin;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{

    public function dashboard()
    {
        $siswa = Siswa::where('nis', session('nis'))->first();

        $data = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('nis', session('nis'))
            ->orderBy('id_pelaporan', 'desc')
            ->get();

        // Ambil username admin yang valid dari database
        $firstAdmin = Admin::first();
        $adminUsername = $firstAdmin ? $firstAdmin->username : 'admin';

        // Buat default aspirasi untuk laporan yang belum punya
        foreach ($data as $d) {
            if (!$d->aspirasi) {
                Aspirasi::create([
                    'id_pelaporan' => $d->id_pelaporan,
                    'username' => $adminUsername,
                    'status' => 'Belum diproses',
                    'feedback' => null
                ]);
            }
        }

        // Refresh data
        $data = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('nis', session('nis'))
            ->orderBy('id_pelaporan', 'desc')
            ->get();

        return view('siswa.dashboard', compact('data', 'siswa'));
    }
    // Menampilkan form ganti password
    public function formGantiPassword()
    {
        $siswa = Siswa::where('nis', session('nis'))->first();
        return view('siswa.ganti-password', compact('siswa'));
    }

    // Memproses ganti password
    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:4|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi!',
            'password_baru.required' => 'Password baru wajib diisi!',
            'password_baru.min' => 'Password baru minimal 4 karakter!',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak sesuai!',
        ]);

        $siswa = Siswa::where('nis', session('nis'))->first();

        // Cek password lama
        if (!Hash::check($request->password_lama, $siswa->password)) {
            return back()->with('error', 'Password lama yang Anda masukkan salah!');
        }

        // Update password baru
        $siswa->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return redirect('/dashboard-siswa')->with('success', 'Password berhasil diubah! Silakan login kembali.');
    }
}
