@extends('layouts.app')

@section('title', 'Perpustakaan Indonesia')

@section('content')
    <div class="p-5 bg-light rounded-3 border">
        <h1 class="display-6 fw-bold">Selamat Datang di Perpustakaan Indonesia</h1>
        <p class="fs-5 text-muted"> Cari Buku di Kesukaan anda
        <p>

        <div class="d-grid gap-2">
            <img src="" alt="">
            <a class="btn btn-primary" href="{{ route('kategori.index') }}" role="button">Lihat Buku</a>
        </div>

    </div>


@endsection
