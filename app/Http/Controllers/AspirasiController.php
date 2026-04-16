<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function form()
    {
        $kategori = Kategori::all();
        return view('siswa.input', compact('kategori'));
    }

    public function store(Request $request)
    {
        // Validasi termasuk file foto
        $request->validate([
            'id_kategori' => 'required',
            'lokasi' => 'required',
            'ket' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // max 2MB
        ]);

        // Proses upload foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/aspirasi'), $fileName);
            $fotoPath = 'uploads/aspirasi/' . $fileName;
        }

        InputAspirasi::create([
            'nis' => session('nis'),
            'id_kategori' => $request->id_kategori,
            'lokasi' => $request->lokasi,
            'ket' => $request->ket,
            'foto' => $fotoPath
        ]);

        return redirect('/dashboard-siswa')->with('success', 'Pengaduan berhasil dikirim!');
    }

    public function edit($id)
    {
        $data = InputAspirasi::where('id_pelaporan', $id)
            ->where('nis', session('nis'))
            ->first();
        $kategori = Kategori::all();

        return view('siswa.edit', compact('data', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $data = InputAspirasi::where('id_pelaporan', $id)
            ->where('nis', session('nis'))
            ->first();

        if (!$data) {
            return redirect('/dashboard-siswa')->with('error', 'Data tidak ditemukan');
        }

        $request->validate([
            'id_kategori' => 'required',
            'lokasi' => 'required',
            'ket' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Proses upload foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($data->foto && file_exists(public_path($data->foto))) {
                unlink(public_path($data->foto));
            }

            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/aspirasi'), $fileName);
            $data->foto = 'uploads/aspirasi/' . $fileName;
        }

        $data->update([
            'id_kategori' => $request->id_kategori,
            'lokasi' => $request->lokasi,
            'ket' => $request->ket,
            'foto' => $data->foto
        ]);

        return redirect('/dashboard-siswa')->with('success', 'Pengaduan berhasil diupdate!');
    }

    public function delete($id)
    {
        // CARA 1: Hapus data di tabel aspirasi dulu (child), baru hapus input_aspirasi (parent)
        \App\Models\Aspirasi::where('id_pelaporan', $id)->delete();

        // Cari data laporan untuk hapus foto
        $laporan = \App\Models\InputAspirasi::find($id);
        if ($laporan && $laporan->foto && file_exists(public_path($laporan->foto))) {
            unlink(public_path($laporan->foto));
        }

        // Hapus laporan utama
        \App\Models\InputAspirasi::where('id_pelaporan', $id)->delete();

        return back()->with('success', 'Laporan berhasil dihapus!');
    }

    public function histori()
    {
        $data = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('nis', session('nis'))
            ->get();

        return view('siswa.histori', compact('data'));
    }
}
