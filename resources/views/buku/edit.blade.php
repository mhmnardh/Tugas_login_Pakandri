@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h4 class="mb-0 fs-5">Edit Buku</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">Kategori</label>
                                    <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                        name="kategori_id" required>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('kategori_id', $buku->kategori_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama_buku" class="form-label">Judul Buku</label>
                                    <input type="text" class="form-control @error('nama_buku') is-invalid @enderror"
                                        id="nama_buku" name="nama_buku" value="{{ old('nama_buku', $buku->nama_buku) }}"
                                        required>
                                    @error('nama_buku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" class="form-control @error('isbn') is-invalid @enderror"
                                        id="isbn" name="isbn" value="{{ old('isbn', $buku->isbn) }}" required>
                                    @error('isbn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                        id="stok" name="stok" value="{{ old('stok', $buku->stok) }}" min="0"
                                        required>
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="foto_buku" class="form-label">Foto Buku (Opsional)</label>
                                    @if ($buku->foto_buku)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $buku->foto_buku) }}" alt="Foto Buku"
                                                class="img-thumbnail" style="height: 100px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('foto_buku') is-invalid @enderror"
                                        id="foto_buku" name="foto_buku" accept="image/*">
                                    @error('foto_buku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">Perbarui Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
