<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputAspirasi extends Model
{
    protected $table = 'input_aspirasi';
    protected $primaryKey = 'id_pelaporan';
    
    public $timestamps = false;
    
    protected $fillable = [
        'nis',
        'id_kategori',
        'lokasi',
        'ket',
        'foto'  // <-- TAMBAHKAN INI
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