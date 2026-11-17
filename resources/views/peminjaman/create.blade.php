@extends('layouts.admin')

@section('title', 'Catat Peminjaman')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
                <h1 class="h3 fw-bold mb-0">Catat Peminjaman</h1>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="member_id" class="form-label">Anggota</label>
                            <select id="member_id" name="member_id"
                                class="form-select @error('member_id') is-invalid @enderror" required>
                                <option value="">Pilih anggota</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}" @selected(old('member_id') == $member->id)>
                                        {{ $member->nama_member }}
                                    </option>
                                @endforeach
                            </select>
                            @error('member_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="buku_id" class="form-label">Buku</label>
                            <select id="buku_id" name="buku_id" class="form-select @error('buku_id') is-invalid @enderror"
                                required>
                                <option value="">Pilih buku</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}" @selected(old('buku_id') == $book->id)>
                                        {{ $book->nama_buku }} (stok {{ $book->stok }})
                                    </option>
                                @endforeach
                            </select>
                            @error('buku_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="tanggal_pinjam" class="form-label">Tanggal pinjam</label>
                                <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
                                    value="{{ old('tanggal_pinjam', now()->toDateString()) }}"
                                    class="form-control @error('tanggal_pinjam') is-invalid @enderror" required>
                                @error('tanggal_pinjam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="tanggal_jatuh_tempo" class="form-label">Jatuh tempo</label>
                                <input type="date" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo"
                                    value="{{ old('tanggal_jatuh_tempo', now()->addDays(14)->toDateString()) }}"
                                    class="form-control @error('tanggal_jatuh_tempo') is-invalid @enderror" required>
                                @error('tanggal_jatuh_tempo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
