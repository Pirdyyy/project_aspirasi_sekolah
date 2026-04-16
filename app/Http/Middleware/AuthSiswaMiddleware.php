<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSiswaMiddleware
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
        // Cek apakah session NIS ada (siswa sudah login)
        if (!session()->has('nis')) {
            // Jika belum login, redirect ke halaman home dengan pesan error
            return redirect('/')->with('error', '🔒 Anda harus login terlebih dahulu untuk mengakses halaman ini!');
        }
        
        // Cek juga jangan sampai admin bisa akses halaman siswa
        if (session()->has('admin')) {
            return redirect('/dashboard-admin')->with('error', 'Anda login sebagai admin, bukan siswa!');
        }
        
        return $next($request);
    }
}