<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_penerbit', 
        'nama', 
        'alamat', 
        'kota', 
        'telepon'
    ];

    // Tambahkan relasi ke Buku
    public function bukus()
    {
        return $this->hasMany(Buku::class, 'penerbit_id');
    }
}
