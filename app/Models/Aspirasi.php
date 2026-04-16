<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $table = 'aspirasi';
    protected $primaryKey = 'id_aspirasi';
    
    public $timestamps = false;
    
    protected $fillable = [
        'id_pelaporan',
        'username',
        'status',
        'feedback'
    ];
    
    // Relasi ke InputAspirasi
    public function inputAspirasi()
    {
        return $this->belongsTo(InputAspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }
}