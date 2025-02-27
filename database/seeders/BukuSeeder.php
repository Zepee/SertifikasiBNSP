<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    public function run()
    {
        Buku::insert([
            ['kode_buku' => 'K1001', 'kategori' => 'Keilmuan', 'nama_buku' => 'Analisis & Perancangan Sistem Informasi', 'harga' => 50000, 'stok' => 60, 'penerbit_id' => 1],
            ['kode_buku' => 'K1002', 'kategori' => 'Keilmuan', 'nama_buku' => 'Artificial Intelligence', 'harga' => 45000, 'stok' => 60, 'penerbit_id' => 1],
            ['kode_buku' => 'K2003', 'kategori' => 'Keilmuan', 'nama_buku' => 'Autocad 3 Dimensi', 'harga' => 40000, 'stok' => 25, 'penerbit_id' => 1],
            ['kode_buku' => 'B1001', 'kategori' => 'Bisnis', 'nama_buku' => 'Bisnis Online', 'harga' => 75000, 'stok' => 9, 'penerbit_id' => 1],
            ['kode_buku' => 'B1002', 'kategori' => 'Bisnis', 'nama_buku' => 'Etika Bisnis dan Tanggung Jawab Sosial', 'harga' => 67500, 'stok' => 20, 'penerbit_id' => 1],
            ['kode_buku' => 'N1001', 'kategori' => 'Novel', 'nama_buku' => 'Cahaya Di Penjuru Hati', 'harga' => 68000, 'stok' => 10, 'penerbit_id' => 2],
            ['kode_buku' => 'N1002', 'kategori' => 'Novel', 'nama_buku' => 'Aku Ingin Cerita', 'harga' => 48000, 'stok' => 12, 'penerbit_id' => 3],
        ]);
    }
}
