<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'password'
    ];
    
    protected $hidden = [
        'password'
    ];
    
    // Relasi ke InputAspirasi
    public function aspirasi()
    {
        return $this->hasMany(InputAspirasi::class, 'nis', 'nis');
    }
}