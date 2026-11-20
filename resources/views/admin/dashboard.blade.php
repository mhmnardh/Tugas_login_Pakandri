@extends('layouts.admin')

@section('title', 'Dashboard Admin | Perpustakaan')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4 mb-lg-5">
        <div>
            <p class="admin-eyebrow mb-2">Ringkasan perpustakaan</p>
            <h1 class="admin-dashboard-title display-6 mb-2">Dashboard</h1>
            <p class="text-secondary mb-0">Selamat datang kembali, {{ session('user_name', 'Administrator') }}.</p>
        </div>
    </div>

    <section class="row g-3 mb-5" aria-label="Statistik perpustakaan">
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="admin-stat d-flex justify-content-between gap-3 p-4">
                <div>
                    <p class="small text-secondary mb-3">Judul buku</p>
                    <p class="admin-stat-value mb-2">{{ number_format($totalBuku) }}</p>
                    <span class="small text-secondary">jenis koleksi terdaftar</span>
                </div>
                <span class="admin-stat-icon admin-action-icon align-self-start" aria-hidden="true">
                    <i class="bi bi-book"></i>
                </span>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="admin-stat d-flex justify-content-between gap-3 p-4">
                <div>
                    <p class="small text-secondary mb-3">Stok tersedia</p>
                    <p class="admin-stat-value mb-2">{{ number_format($stokTersedia) }}</p>
                    <span class="small text-secondary">eksemplar di perpustakaan</span>
                </div>
                <span class="admin-stat-icon admin-icon-stock align-self-start" aria-hidden="true">
                    <i class="bi bi-box-seam"></i>
                </span>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="admin-stat d-flex justify-content-between gap-3 p-4">
                <div>
                    <p class="small text-secondary mb-3">Kategori</p>
                    <p class="admin-stat-value mb-2">{{ number_format($totalKategori) }}</p>
                    <span class="small text-secondary">kelompok koleksi</span>
                </div>
                <span class="admin-stat-icon admin-icon-category align-self-start" aria-hidden="true">
                    <i class="bi bi-tags"></i>
                </span>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="admin-stat d-flex justify-content-between gap-3 p-4">
                <div>
                    <p class="small text-secondary mb-3">Anggota</p>
                    <p class="admin-stat-value mb-2">{{ number_format($totalMember) }}</p>
                    <span class="small text-secondary">anggota terdaftar</span>
                </div>
                <span class="admin-stat-icon admin-icon-member align-self-start" aria-hidden="true">
                    <i class="bi bi-people"></i>
                </span>
            </article>
        </div>
    </section>

    <section class="row g-4">
        <div class="col-12 col-lg-7">
            <h2 class="h5 fw-bold mb-1">Kelola data</h2>
            <p class="small text-secondary mb-3">Lihat dan perbarui catatan perpustakaan.</p>
            <div class="admin-action-list">
                <a class="admin-action" href="{{ route('buku.create') }}">
                    <span class="d-flex align-items-center gap-3">
                        <span class="admin-action-icon" aria-hidden="true"><i class="bi bi-book"></i></span>
                        <span><strong class="d-block">Tambah buku</strong><small class="text-secondary">Masukkan koleksi
                                baru</small></span>
                    </span>
                    <i class="admin-action-arrow bi bi-arrow-right" aria-hidden="true"></i>
                </a>
                <a class="admin-action" href="{{ route('kategori.index') }}">
                    <span class="d-flex align-items-center gap-3">
                        <span class="admin-action-icon admin-icon-category" aria-hidden="true"><i
                                class="bi bi-tags"></i></span>
                        <span><strong class="d-block">Kategori</strong><small class="text-secondary">Atur kelompok
                                koleksi</small></span>
                    </span>
                    <i class="admin-action-arrow bi bi-arrow-right" aria-hidden="true"></i>
                </a>
                <a class="admin-action" href="{{ route('member.index') }}">
                    <span class="d-flex align-items-center gap-3">
                        <span class="admin-action-icon admin-icon-member" aria-hidden="true"><i
                                class="bi bi-people"></i></span>
                        <span><strong class="d-block">Member</strong><small class="text-secondary">Kelola data
                                peminjam</small></span>
                    </span>
                    <i class="admin-action-arrow bi bi-arrow-right" aria-hidden="true"></i>
                </a>
                <a class="admin-action" href="{{ route('peminjaman.index') }}">
                    <span class="d-flex align-items-center gap-3">
                        <span class="admin-action-icon admin-icon-category" aria-hidden="true"><i
                                class="bi bi-arrow-left-right"></i></span>
                        <span><strong class="d-block">Peminjaman</strong><small class="text-secondary">Catat dan pantau
                                pengembalian buku</small></span>
                    </span>
                    <i class="admin-action-arrow bi bi-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>

    </section>
@endsection
