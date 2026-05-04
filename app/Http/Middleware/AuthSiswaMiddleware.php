<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSiswaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Jika tidak ada session nis (belum login sebagai siswa)
        if (!session()->has('nis')) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu!');
        }

        // Jika session admin ada (admin login), jangan izinkan akses halaman siswa
        if (session()->has('admin')) {
            return redirect('/dashboard-admin')->with('error', 'Anda login sebagai admin!');
        }

        return $next($request);
    }
}
