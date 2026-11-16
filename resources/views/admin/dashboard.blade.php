@extends('layouts.admin')

@section('title', 'Dashboard Admin | Perpustakaan')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <p class="small text-success text-uppercase fw-bold mb-2">Ringkasan perpustakaan</p>
            <h1 class="h2 fw-bold mb-1">Dashboard</h1>
            <p class="text-secondary mb-0">Halo, {{ session('user_name', 'Administrator') }}. Berikut kondisi koleksi saat
                ini.</p>
        </div>
    </div>

    <section class="row g-3 mb-5" aria-label="Statistik perpustakaan">
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="admin-stat p-4">
                <p class="small text-secondary mb-3">Judul buku</p>
                <p class="admin-stat-value mb-2">{{ number_format($totalBuku) }}</p>
                <span class="small text-secondary">jenis koleksi terdaftar</span>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="admin-stat p-4">
                <p class="small text-secondary mb-3">Stok tersedia</p>
                <p class="admin-stat-value mb-2">{{ number_format($stokTersedia) }}</p>
                <span class="small text-secondary">eksemplar di perpustakaan</span>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="admin-stat p-4">
                <p class="small text-secondary mb-3">Kategori</p>
                <p class="admin-stat-value mb-2">{{ number_format($totalKategori) }}</p>
                <span class="small text-secondary">kelompok koleksi</span>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="admin-stat p-4">
                <p class="small text-secondary mb-3">Member</p>
                <p class="admin-stat-value mb-2">{{ number_format($totalMember) }}</p>
                <span class="small text-secondary">data peminjam tercatat</span>
            </article>
        </div>
    </section>

    <section class="row g-5">
        <div class="col-12 col-lg-7">
            <h2 class="h5 fw-bold mb-1">Akses cepat</h2>
            <p class="small text-secondary mb-3">Kelola data utama perpustakaan.</p>
            <div class="bg-white border rounded-2 px-3">
                <a class="admin-action" href="{{ route('buku.create') }}">
                    <span><strong class="d-block">Tambah buku</strong><small class="text-secondary">Masukkan koleksi
                            baru</small></span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
                <a class="admin-action" href="{{ route('kategori.create') }}">
                    <span><strong class="d-block">Tambah kategori</strong><small class="text-secondary">Atur kelompok
                            koleksi</small></span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
                <a class="admin-action" href="{{ route('member.create') }}">
                    <span><strong class="d-block">Tambah member</strong><small class="text-secondary">Catat member dan
                            peminjaman</small></span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </section>
@endsection
