<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Member;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(): View
    {
        $peminjaman = Peminjaman::with(['member', 'buku'])->latest()->paginate(15);

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create(): View
    {
        $members = Member::orderBy('nama_member')->get();
        $books = Buku::where('stok', '>', 0)->orderBy('nama_buku')->get();

        return view('peminjaman.create', compact('members', 'books'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:member,id'],
            'buku_id' => ['required', 'exists:buku,id'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_jatuh_tempo' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
        ]);

        DB::transaction(function () use ($validated): void {
            $buku = Buku::whereKey($validated['buku_id'])->lockForUpdate()->firstOrFail();

            if ($buku->stok < 1) {
                throw ValidationException::withMessages([
                    'buku_id' => 'Stok buku sudah habis.',
                ]);
            }

            $buku->decrement('stok');

            Peminjaman::create([
                ...$validated,
                'status' => 'dipinjam',
            ]);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function returnBook(Peminjaman $peminjaman): RedirectResponse
    {
        $dikembalikan = DB::transaction(function () use ($peminjaman): bool {
            $peminjaman = Peminjaman::whereKey($peminjaman->id)->lockForUpdate()->firstOrFail();

            if ($peminjaman->status !== 'dipinjam') {
                return false;
            }

            $buku = Buku::whereKey($peminjaman->buku_id)->lockForUpdate()->first();
            if ($buku) {
                $buku->increment('stok');
            }

            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now()->toDateString(),
            ]);

            return true;
        });

        if (! $dikembalikan) {
            return redirect()->route('peminjaman.index')->with('error', 'Peminjaman ini sudah dikembalikan.');
        }

        return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dikembalikan.');
    }
}
