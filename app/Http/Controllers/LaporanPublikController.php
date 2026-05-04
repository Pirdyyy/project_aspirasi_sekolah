<?php

namespace App\Http\Controllers;

use App\Models\InputAspirasi;
use Illuminate\Http\Request;

class LaporanPublikController extends Controller
{
    public function index()
    {
        $laporan = InputAspirasi::with(['siswa', 'kategori', 'aspirasi'])
            ->orderBy('id_pelaporan', 'desc')
            ->get();
        
        return view('laporan-publik', compact('laporan'));
    }
}