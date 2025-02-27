<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku')->unique();
            $table->string('nama_buku');
            $table->string('kategori');
            $table->unsignedBigInteger('penerbit_id');
            $table->integer('harga');
            $table->integer('stok');
            $table->timestamps();
            
            $table->foreign('penerbit_id')->references('id')->on('penerbits')->onDelete('cascade');
        });
        
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
