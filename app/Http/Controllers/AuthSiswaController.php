<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class AuthSiswaController extends Controller
{
    public function formRegister()
    {
        return view('siswa.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama' => 'required',
            'kelas' => 'required',
            'password' => 'required|min:3'
        ], [
            'nis.unique' => 'NIS sudah terdaftar!',
            'nis.required' => 'NIS wajib diisi!',
            'nama.required' => 'Nama wajib diisi!',
            'kelas.required' => 'Kelas wajib diisi!', // 🔥 INI
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 3 karakter!'
        ]);

        $siswa = Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'password' => Hash::make($request->password)

        ]);
        // langsung login (set session)
        session(['nis' => $siswa->nis]);

        // langsung ke dashboard
        return redirect('/dashboard-siswa');
    }

    public function formlogin()
    {
        return view('siswa.login');
    }

    public function login(Request $request)
    {
        $siswa = Siswa::where('nis', $request->nis)->first();

        // ❌ NIS tidak ditemukan
        if (!$siswa) {
            return redirect('/')->with('error', 'NIS tidak ditemukan!');
        }

        // ❌ Password salah
        if (!Hash::check($request->password, $siswa->password)) {
            return redirect('/')->with('error', 'Password salah!');
        }

        // ✅ Login berhasil
        session(['nis' => $siswa->nis]);
        return redirect('/dashboard-siswa');
    }

    public function logout()
    {
        session()->forget('nis');
        return redirect('/');
    }
}
