@extends(session()->has('user_id') ? 'layouts.admin' : 'layouts.app')

@section('title', 'Tambah Buku')

@section('content')
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-on-accent">
                            <h4 class="mb-0 fs-5">Tambah Buku</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">Kategori</label>
                                    <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                        name="kategori_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
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
                                        id="nama_buku" name="nama_buku" value="{{ old('nama_buku') }}" required>
                                    @error('nama_buku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" class="form-control @error('isbn') is-invalid @enderror"
                                        id="isbn" name="isbn" value="{{ old('isbn') }}" required>
                                    @error('isbn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                        id="stok" name="stok" value="{{ old('stok') }}" min="0" required>
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="foto_buku" class="form-label">Foto Buku (Opsional)</label>
                                    <input type="file" class="form-control @error('foto_buku') is-invalid @enderror"
                                        id="foto_buku" name="foto_buku" accept="image/*">
                                    @error('foto_buku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
