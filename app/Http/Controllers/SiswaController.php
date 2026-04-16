<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\InputAspirasi;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $siswa = Siswa::where('nis', session('nis'))->first();

        $data = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('nis', session('nis'))
            ->get();

        return view('siswa.dashboard', compact('data', 'siswa'));
    }
}