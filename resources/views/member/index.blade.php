@extends(session()->has('user_id') ? 'layouts.admin' : 'layouts.app')

@section('title', 'Daftar Member')

@section('content')
    <main>
        <section class=" text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Daftar Member</h1>
                    <p class="lead text-body-secondary">Kelola data member dan buku yang mereka miliki.</p>
                    @if (session('user_id'))
                        <p>
                            <a href="{{ route('member.create') }}" class="btn btn-primary my-2">
                                Tambah Member Baru
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

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @forelse ($member as $item)
                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0 fs-6 fw-bold">{{ $item->nama_member }}</h5>
                                </div>

                                @if ($item->foto_member)
                                    <img src="{{ asset('storage/' . $item->foto_member) }}" class="card-img-top"
                                        alt="{{ $item->nama_member }}" style="height: 225px; object-fit: cover;">
                                @else
                                    <svg aria-label="Placeholder: Thumbnail" class="bd-placeholder-img card-img-top"
                                        height="225" preserveAspectRatio="xMidYMid slice" role="img" width="100%"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <title>Foto Member</title>
                                        <rect width="100%" height="100%" fill="#55595c"></rect>
                                        <text x="50%" y="50%" fill="#eceeef" dy=".3em">No Image</text>
                                    </svg>
                                @endif

                                <div class="card-body">
                                    <p class="card-text text-muted mb-2">
                                        <strong>Buku:</strong> {{ $item->buku?->nama_buku ?? 'Belum terhubung' }}
                                    </p>
                                    <p class="card-text text-muted mb-2">
                                        <strong>Email:</strong> {{ $item->email }}
                                    </p>
                                    <p class="card-text text-muted mb-2">
                                        <strong>No Telepon:</strong> {{ $item->no_telepon }}
                                    </p>
                                    <p class="card-text text-muted mb-0">
                                        <strong>Tgl Lahir:</strong>
                                        {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}
                                    </p>
                                </div>

                                <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                                    @if (session('user_id'))
                                        <div class="btn-group">
                                            <a href="{{ route('member.edit', $item->id) }}"
                                                class="btn btn-sm btn-outline-secondary">Edit</a>
                                            <form action="{{ route('member.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-body-secondary small">Read only</span>
                                    @endif
                                    <small class="text-body-secondary">{{ $item->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Belum ada data member yang ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection
