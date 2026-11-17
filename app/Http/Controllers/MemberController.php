<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $member = Member::latest()->get();

        return view('member.index', compact('member'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_member' => 'required|string|max:255',
            'email' => 'required|email|unique:member,email',
            'no_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'foto_member' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_member', 'email', 'no_telepon', 'tanggal_lahir']);

        if ($request->hasFile('foto_member')) {
            $data['foto_member'] = $request->file('foto_member')->store('member', 'public');
        }

        Member::create($data);

        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan!');
    }

    public function edit(Member $member)
    {
        return view('member.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama_member' => 'required|string|max:255',
            'email' => 'required|email|unique:member,email,' . $member->id,
            'no_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'foto_member' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_member', 'email', 'no_telepon', 'tanggal_lahir']);

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
        $member->delete();

        return redirect()->route('member.index')->with('success', 'Member berhasil diarsipkan. Riwayat peminjaman tetap tersimpan.');
    }
}
