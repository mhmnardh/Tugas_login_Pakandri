<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->latest()->get();

        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        $kategori = Kategori::all();

        return view('buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama_buku' => 'required|string|max:255',
            'isbn' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'foto_buku' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_buku')) {
            $data['foto_buku'] = $request->file('foto_buku')->store('buku', 'public');
        }

        Buku::create($data);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Buku $buku)
    {
        $kategori = Kategori::all();

        return view('buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama_buku' => 'required|string|max:255',
            'isbn' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'foto_buku' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_buku')) {
            if ($buku->foto_buku) {
                Storage::disk('public')->delete($buku->foto_buku);
            }
            $data['foto_buku'] = $request->file('foto_buku')->store('buku', 'public');
        }

        $buku->update($data);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->peminjaman()->where('status', 'dipinjam')->exists()) {
            return redirect()->route('buku.index')
                ->with('error', 'Buku tidak dapat dihapus selama masih dipinjam.');
        }

        if ($buku->foto_buku) {
            Storage::disk('public')->delete($buku->foto_buku);
        }

        $buku->member()->update(['buku_id' => null]);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus! Data member tetap aman.');
    }
}
