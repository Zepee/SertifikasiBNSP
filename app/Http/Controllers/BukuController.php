<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Menampilkan halaman katalog buku dengan fitur filter dan sort
     */
    public function index(Request $request)
    {
        $query = Buku::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_buku', 'LIKE', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Pengurutan
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'nama_asc':
                    $query->orderBy('nama_buku', 'asc');
                    break;
                case 'nama_desc':
                    $query->orderBy('nama_buku', 'desc');
                    break;
                case 'harga_asc':
                    $query->orderBy('harga', 'asc');
                    break;
                case 'harga_desc':
                    $query->orderBy('harga', 'desc');
                    break;
            }
        }

        $bukus = $query->get();
        return view('index', compact('bukus'));
    }
    



    /**
     * Menampilkan halaman admin dengan daftar buku dan penerbit
     */
    public function admin(Request $request)
    {
        $query = Buku::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_buku', 'LIKE', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Pengurutan
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'nama_asc':
                    $query->orderBy('nama_buku', 'asc');
                    break;
                case 'nama_desc':
                    $query->orderBy('nama_buku', 'desc');
                    break;
                case 'harga_asc':
                    $query->orderBy('harga', 'asc');
                    break;
                case 'harga_desc':
                    $query->orderBy('harga', 'desc');
                    break;
            }
        }

        $bukus = $query->get();
        $penerbits = Penerbit::withCount('bukus')->get();

        return view('admin', compact('bukus', 'penerbits'));
    }

    /**
     * Menampilkan form untuk menambah buku baru
     */
    public function create()
    {
        $penerbits = Penerbit::all();
        return view('buku.create', compact('penerbits'));
    }

    /**
     * Menyimpan data buku baru ke database
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode_buku' => 'required|unique:bukus',
                'nama_buku' => 'required|string|max:255',
                'kategori' => 'required|string|in:Keilmuan,Bisnis,Novel',
                'harga' => 'required|numeric|min:0',
                'stok' => 'required|integer|min:0',
                'penerbit_id' => 'required|exists:penerbits,id',
            ]);

            Buku::create($validated);

            return redirect()
                ->route('admin')
                ->with('success', 'Buku berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan buku!')
                ->withInput();
        }
    }

    /**
     * Mengupdate data buku yang sudah ada
     */
    public function update(Request $request, Buku $buku)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_buku' => 'required|string|max:255',
            'kategori' => 'required|string|in:Keilmuan,Bisnis,Novel',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'penerbit_id' => 'required|exists:penerbits,id',
        ]);

        try {
            // Update buku dengan data yang sudah divalidasi
            $buku->update($validated);

            // Jika request dari AJAX (modal)
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Buku berhasil diperbarui',
                    'buku' => $buku
                ]);
            }

            // Redirect dengan pesan sukses
            return redirect()
                ->route('admin')
                ->with('success', 'Buku berhasil diperbarui');

        } catch (\Exception $e) {
            // Handle error
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui buku'
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui buku')
                ->withInput();
        }
    }

    /**
     * Menghapus data buku dari database
     */
    public function destroy(Buku $buku)
    {
        try {
            $buku->delete();
            return redirect()
                ->route('admin')
                ->with('success', 'Buku berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin')
                ->with('error', 'Gagal menghapus buku!');
        }
    }

    /**
     * Menampilkan daftar buku yang stoknya <= 10
     */
    public function pengadaan()
    {
        $bukus = Buku::where('stok', '<=', 10)->get();
        return view('pengadaan', compact('bukus'));
    }
}
