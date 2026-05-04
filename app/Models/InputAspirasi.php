<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputAspirasi extends Model
{
    protected $table = 'input_aspirasi';
    protected $primaryKey = 'id_pelaporan';

    // HAPUS atau KOMENTAR baris ini (atau ubah jadi true)
    public $timestamps = true;  // <-- UBAH jadi true (default true)

    protected $fillable = [
        'nis',
        'id_kategori',
        'lokasi',
        'ket',
        'foto'
    ];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function aspirasi()
    {
        return $this->hasOne(Aspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }
}
