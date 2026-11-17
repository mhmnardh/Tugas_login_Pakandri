@extends('layouts.app')

@section('title', 'Perpustakaan Indonesia')

@section('content')
    <section class="library-hero rounded-3" style="--library-background-image: url('{{ asset('images/perpus.jpg') }}')">
        <div class="library-hero-content">
            <h1 class="display-6 fw-bold">Selamat Datang di Perpustakaan Indonesia</h1>
            <p class="fs-5 text-white-50">Temukan buku favorit Anda dan mulai petualangan membaca.</p>
            <a class="btn btn-light fw-semibold" href="{{ route('kategori.index') }}" role="button">Lihat Buku</a>
        </div>
    </section>
@endsection
