<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $member = Member::with('buku')->latest()->get();
        return view('member.index', compact('member'));
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $bukuTersedia = Buku::where('stok', '>', 0)->get();
        return view('member.create', compact('bukuTersedia'));
    }

    public function store(Request $request)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $request->validate([
            'buku_id'       => ['required', 'exists:buku,id', function ($attribute, $value, $fail) {
                $buku = Buku::find($value);

                if (! $buku || $buku->stok <= 0) {
                    $fail('Buku ini sudah habis dan tidak bisa dipinjam.');
                }
            }],
            'nama_member'   => 'required|string|max:255',
            'email'         => 'required|email|unique:member,email',
            'no_telepon'    => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'foto_member'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_member')) {
            $data['foto_member'] = $request->file('foto_member')->store('member', 'public');
        }

        Member::create($data);

        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan!');
    }

    public function edit(Member $member)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $bukuTersedia = Buku::where('stok', '>', 0)->get();

        if ($member->buku_id) {
            $bukuSaatIni = Buku::find($member->buku_id);

            if ($bukuSaatIni && ! $bukuTersedia->contains('id', $member->buku_id)) {
                $bukuTersedia->prepend($bukuSaatIni);
            }
        }

        return view('member.edit', compact('member', 'bukuTersedia'));
    }

    public function update(Request $request, Member $member)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $request->validate([
            'buku_id'       => ['required', 'exists:buku,id', function ($attribute, $value, $fail) use ($member) {
                if ($member->buku_id == $value) {
                    return;
                }

                $buku = Buku::find($value);

                if (! $buku || $buku->stok <= 0) {
                    $fail('Buku ini sudah habis dan tidak bisa dipinjam.');
                }
            }],
            'nama_member'   => 'required|string|max:255',
            'email'         => 'required|email|unique:member,email,' . $member->id,
            'no_telepon'    => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'foto_member'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_member')) {
            if ($member->foto_member) {
                Storage::disk('public')->delete($member->foto_member);
            }
            $data['foto_member'] = $request->file('foto_member')->store('member', 'public');
        }

        $member->update($data);

        return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        if ($member->foto_member) {
            Storage::disk('public')->delete($member->foto_member);
        }
        $member->delete();

        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus!');
    }
}
