<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('buku')->get();
        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('kategori.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Kategori $kategori)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $kategori->buku()->update(['kategori_id' => null]);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus! Buku tetap tersimpan.');
    }
}
