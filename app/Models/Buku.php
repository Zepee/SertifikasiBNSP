<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus'; // atau sesuaikan dengan nama tabel Anda
    
    protected $fillable = [
        'kode_buku', 
        'nama_buku', 
        'kategori', 
        'harga', 
        'stok', 
        'penerbit_id'
    ];

    // Tambahkan relasi ke Penerbit
    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'penerbit_id');
    }
}
