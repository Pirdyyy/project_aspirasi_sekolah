<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AuthAdminController extends Controller
{
    // Menampilkan form login admin (GET)
    public function showLoginForm()
    {
        // Cek jika sudah login sebagai admin
        if (session('admin')) {
            return redirect('/dashboard-admin');
        }
        
        // Cek jika sudah login sebagai siswa
        if (session('nis')) {
            return redirect('/dashboard-siswa');
        }
        
        return view('admin.login'); // Buat file view ini
    }

    // Proses login admin (POST)
    public function login(Request $request)
    {
        $admin = Admin::where('username', $request->username)
                      ->where('password', $request->password)
                      ->first();

        if ($admin) {
            session(['admin' => $admin->username]);
            return redirect('/dashboard-admin');
        }

        return redirect('/')->with('error', 'Login gagal! Username atau password salah.');
    }

    public function logout()
    {
        session()->forget('admin');
        return redirect('/')->with('success', 'Anda telah logout dari akun admin.');
    }
}