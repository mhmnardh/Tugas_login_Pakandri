@extends(session()->has('user_id') ? 'layouts.admin' : 'layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <main>
        <section class="list-heading text-center">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Daftar Buku</h1>
                    <p class="lead text-body-secondary">Lihat data buku dan stok yang tersedia di perpustakaan .</p>
                    @if (session('user_id'))
                        <p>
                            <a href="{{ route('buku.create') }}" class="btn btn-primary my-2">
                                <i class="bi bi-plus-lg"></i> Tambah Buku Baru
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </section>

        <div class="album bg-body-tertiary">
            <div class="container">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-warning mb-4" role="alert">{{ session('error') }}</div>
                @endif

                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xxl-4 g-3">
                    @forelse ($buku as $item)
                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div
                                    class="card-header bg-primary text-on-accent d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0 fw-bold">{{ $item->nama_buku }}</h5>
                                </div>

                                @if ($item->foto_buku)
                                    <img src="{{ asset('storage/' . $item->foto_buku) }}" class="card-img-top"
                                        alt="{{ $item->nama_buku }}" style="height: 225px; object-fit: cover;">
                                @else
                                    <svg aria-label="Placeholder: Thumbnail" class="bd-placeholder-img card-img-top"
                                        height="225" preserveAspectRatio="xMidYMid slice" role="img" width="100%"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <title>Foto Buku</title>
                                        <rect width="100%" height="100%" fill="var(--bg-secondary)"></rect>
                                        <text x="50%" y="50%" fill="var(--text-secondary)" dy=".3em">No Image</text>
                                    </svg>
                                @endif



                                <div class="card-body">
                                    <p class="card-text text-muted mb-2">
                                        <strong>Kategori:</strong>
                                        {{ $item->kategori?->nama_kategori ?? 'Tidak ada kategori' }}
                                    </p>
                                    <p class="card-text text-muted mb-2">
                                        <strong>ISBN:</strong> {{ $item->isbn }}
                                    </p>
                                    <p class="card-text text-muted mb-0">
                                        <strong>Stok:</strong> {{ $item->stok > 0 ? $item->stok : 'Habis' }}
                                    </p>
                                </div>

                                <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                                    @if (session('user_id'))
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ route('buku.edit', $item->id) }}"
                                                class="btn btn-sm btn-outline-secondary">Edit</a>

                                            <form action="{{ route('buku.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-body-secondary small">Read only</span>
                                    @endif
                                    <small
                                        class="text-body-secondary">{{ $item->created_at?->diffForHumans() ?? '-' }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Belum ada data buku yang ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection
