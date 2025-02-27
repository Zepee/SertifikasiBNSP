<?php

namespace App\Http\Controllers;

use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    /**
     * Menampilkan daftar semua penerbit
     */
    public function index()
    {
        $penerbits = Penerbit::all();
        return view('penerbit.index', compact('penerbits'));
    }

    /**
     * Menampilkan form untuk membuat penerbit baru
     */
    public function create()
    {
        return view('penerbit.create');
    }

    /**
     * Menyimpan data penerbit baru ke database
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode_penerbit' => 'required|unique:penerbits',
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string',
                'kota' => 'required|string',
                'telepon' => 'required|string',
            ]);

            Penerbit::create($validated);

            return redirect()
                ->route('admin')
                ->with('success', 'Penerbit berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan penerbit!')
                ->withInput();
        }
    }

    /**
     * Menampilkan form untuk mengedit penerbit
     */
    public function edit(Penerbit $penerbit)
    {
        return view('penerbit.edit', compact('penerbit'));
    }

    /**
     * Mengupdate data penerbit yang sudah ada
     */
    public function update(Request $request, Penerbit $penerbit)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string',
                'kota' => 'required|string',
                'telepon' => 'required|string',
            ]);

            $penerbit->update($validated);

            return redirect()
                ->route('admin')
                ->with('success', 'Penerbit berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui penerbit!')
                ->withInput();
        }
    }

    /**
     * Menghapus data penerbit jika tidak memiliki buku
     */
    public function destroy(Penerbit $penerbit)
    {
        try {
            if ($penerbit->bukus()->count() > 0) {
                return redirect()
                    ->route('admin')
                    ->with('error', 'Tidak dapat menghapus penerbit yang masih memiliki buku!');
            }

            $penerbit->delete();
            return redirect()
                ->route('admin')
                ->with('success', 'Penerbit berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin')
                ->with('error', 'Gagal menghapus penerbit!');
        }
    }
}

