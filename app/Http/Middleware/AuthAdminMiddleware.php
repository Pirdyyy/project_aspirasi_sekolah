<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah session admin ada (admin sudah login)
        if (!session()->has('admin')) {
            // Jika belum login, redirect ke halaman home dengan pesan error
            return redirect('/')->with('error', '🔒 Anda harus login sebagai admin terlebih dahulu!');
        }
        
        // Cek juga jangan sampai siswa bisa akses halaman admin
        if (session()->has('nis')) {
            return redirect('/dashboard-siswa')->with('error', 'Anda login sebagai siswa, bukan admin!');
        }
        
        return $next($request);
    }
}