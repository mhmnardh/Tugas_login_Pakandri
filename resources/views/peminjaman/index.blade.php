@extends('layouts.admin')

@section('title', 'Peminjaman')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <p class="admin-eyebrow mb-2">Sirkulasi buku</p>
            <h1 class="h2 fw-bold mb-0">Peminjaman</h1>
        </div>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-admin-primary px-3 py-2">
            <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Catat peminjaman
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-warning" role="alert">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th scope="col">Anggota</th>
                    <th scope="col">Buku</th>
                    <th scope="col">Tanggal pinjam</th>
                    <th scope="col">Jatuh tempo</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $item)
                    <tr>
                        <td>{{ $item->member?->nama_member ?? 'Anggota diarsipkan' }}</td>
                        <td>{{ $item->buku?->nama_buku ?? 'Buku tidak tersedia' }}</td>
                        <td>{{ $item->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                        <td>{{ $item->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $item->status === 'dipinjam' ? 'text-bg-warning' : 'text-bg-success' }}">
                                {{ $item->status === 'dipinjam' ? 'Dipinjam' : 'Dikembalikan' }}
                            </span>
                        </td>
                        <td class="text-end">
                            @if ($item->status === 'dipinjam')
                                <form action="{{ route('peminjaman.return', $item) }}" method="POST"
                                    onsubmit="return confirm('Tandai buku ini sudah dikembalikan?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Kembalikan</button>
                                </form>
                            @else
                                <span class="text-secondary small">
                                    {{ $item->tanggal_kembali?->format('d M Y') ?? '-' }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-5 text-center text-secondary">Belum ada data peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $peminjaman->links() }}
@endsection
