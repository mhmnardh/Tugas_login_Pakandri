@extends('layouts.app')

@section('title', 'Perpustakaan Indonesia')

@section('content')

    <!-- HERO SECTION -->
    @if (request()->routeIs('class.index'))
        <section class="hero-section">
            <div class="container-fluid hero-container">

                <div class="row align-items-center">

                    <div class="col-lg-7 hero-content">

                        <span class="hero-label">
                            ✦ SELAMAT DATANG DI PERPUSTAKAAN INDONESIA
                        </span>

                        <h1>
                            Temukan Dunia
                            <span>Melalui Buku.</span>
                        </h1>

                        <p>
                            Jelajahi berbagai koleksi buku, perluas wawasan,
                            dan temukan inspirasi baru. Karena setiap buku
                            memiliki cerita dan pengetahuan yang berharga.
                        </p>

                        <div class="hero-actions">

                            <a href="{{ route('buku.index') }}" class="btn btn-primary-custom">
                                Jelajahi Buku
                                <span>→</span>
                            </a>

                            <a href="{{ route('kategori.index') }}" class="btn btn-outline-custom">
                                Lihat Kategori
                            </a>

                        </div>

                        <div class="hero-note">
                            <span class="note-line"></span>
                            <span>Tempat terbaik untuk memulai perjalanan ilmu.</span>
                        </div>

                    </div>

                    <div class="col-lg-5 hero-image-wrapper">

                        <div class="hero-image-decoration"></div>

                        <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=1000"
                            alt="Suasana perpustakaan" class="hero-image">

                        <div class="floating-card">
                            <span>✦</span>
                            <div>
                                <strong>Read More</strong>
                                <small>Discover More</small>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>

        <!-- INTRO SECTION -->
        <section class="intro-section">
            <div class="container-fluid site-content">

                <div class="row align-items-center">

                    <div class="col-lg-5">
                        <span class="section-label">TENTANG KAMI</span>

                        <h2>
                            Lebih dari sekadar
                            <span>tempat membaca.</span>
                        </h2>
                    </div>

                    <div class="col-lg-6 offset-lg-1">
                        <p>
                            Perpustakaan Indonesia hadir sebagai ruang
                            untuk belajar, membaca, dan mengembangkan
                            pengetahuan. Temukan koleksi bacaan yang
                            sesuai dengan minat dan kebutuhanmu.
                        </p>
                    </div>

                </div>

                <div class="row g-4 mt-4">

                    <div class="col-md-4">
                        <div class="feature-card">
                            <span class="feature-number">01</span>
                            <h4>Koleksi Buku</h4>
                            <p>Temukan berbagai pilihan buku dari beragam kategori.</p>
                            <a href="{{ route('buku.index') }}">Jelajahi koleksi →</a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="feature-card">
                            <span class="feature-number">02</span>
                            <h4>Kategori Buku</h4>
                            <p>Temukan bacaan berdasarkan topik dan minat favoritmu.</p>
                            <a href="{{ route('kategori.index') }}">Lihat kategori →</a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="feature-card">
                            <span class="feature-number">03</span>
                            <h4>Keanggotaan</h4>
                            <p>Kelola data anggota perpustakaan dengan mudah.</p>
                            <a href="{{ route('member.index') }}">Lihat member →</a>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    @endif

@endsection
