<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'username',
        'nama',
        'password',
        'ket_kategori'
    ];

    public function aspirasi()
    {
        return $this->hasMany(Aspirasi::class, 'username', 'username');
    }
}
