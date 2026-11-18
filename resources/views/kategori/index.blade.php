@extends(session()->has('user_id') ? 'layouts.admin' : 'layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
    <main>
        <section class="list-heading text-center">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Daftar Kategori</h1>
                    <p class="lead text-body-secondary">Lihat kategori buku yang tersedia di perpustakaan</p>
                    @if (session('user_id'))
                        <p>
                            <a href="{{ route('kategori.create') }}" class="btn btn-primary my-2">
                                <i class="bi bi-plus-lg"></i> Tambah Kategori Baru
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

                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xxl-4 g-3">
                    @forelse ($kategori as $item)
                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div
                                    class="card-header bg-primary text-on-accent d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0 fw-bold">{{ $item->nama_kategori }}</h5>
                                </div>

                                <div class="card-body">
                                    <p class="card-text text-muted mb-2">
                                        <strong>Jumlah Buku:</strong> {{ $item->buku_count }}
                                    </p>
                                </div>

                                <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                                    @if (session('user_id'))
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ route('kategori.edit', $item->id) }}"
                                                class="btn btn-sm btn-outline-secondary">Edit</a>
                                            <form action="{{ route('kategori.destroy', $item->id) }}" method="POST"
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
                            <p class="text-muted">Belum ada data kategori yang ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection
