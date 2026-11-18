<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Perpustakaan Indonesia')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Google+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <!-- NAVBAR -->
    <nav class="site-nav navbar navbar-expand-lg">
        <div class="container-fluid site-nav-inner">

            <a href="/" class="site-brand">
                <img src="{{ asset('images/perpustakaan.png') }}" alt="Logo Perpustakaan">

                <div>
                    <span class="brand-name">Perpustakaan</span>
                    <span class="brand-subtitle">INDONESIA</span>
                </div>
            </a>

            <button class="navbar-toggler custom-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar" aria-label="Buka navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">

                <ul class="navbar-nav align-items-lg-center gap-lg-2">

                    <li class="nav-item">
                        <a href="{{ route('class.index') }}"
                            class="nav-link {{ request()->routeIs('class.index') ? 'active' : '' }}">
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('kategori.index') }}"
                            class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                            Kategori
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('buku.index') }}"
                            class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}">
                            Buku
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('member.index') }}"
                            class="nav-link {{ request()->routeIs('member.*') ? 'active' : '' }}">
                            Member
                        </a>
                    </li>

                    @if (session('user_id'))
                        <li class="nav-item ms-lg-3">
                            <a href="#" class="nav-link logout-link"
                                onclick="event.preventDefault(); document.getElementById('logout-form').requestSubmit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"
                                onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item ms-lg-3">
                            <a href="{{ route('login') }}" class="btn btn-login">
                                Login
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="site-main">
        <div class="container-fluid site-content {{ request()->routeIs('class.index') ? '' : 'page-surface' }}">
            @yield('content')
        </div>
    </main>


    <!-- FOOTER -->
    <footer class="site-footer">

        <div class="container-fluid site-content">

            <div class="row gy-4">

                <div class="col-lg-5">

                    <a href="/" class="site-brand footer-brand">

                        <img src="{{ asset('images/perpustakaan.png') }}" alt="Logo Perpustakaan">

                        <div>
                            <span class="brand-name">Perpustakaan</span>
                            <span class="brand-subtitle">INDONESIA</span>
                        </div>

                    </a>

                    <p class="footer-description">
                        Membuka jendela dunia melalui pengetahuan,
                        membaca, dan literasi.
                    </p>

                </div>

                <div class="col-lg-3 col-md-6">

                    <h5>Navigasi</h5>

                    <ul class="footer-links">
                        <li><a href="{{ route('class.index') }}">Home</a></li>
                        <li><a href="{{ route('kategori.index') }}">Kategori</a></li>
                        <li><a href="{{ route('buku.index') }}">Buku</a></li>
                        <li><a href="{{ route('member.index') }}">Member</a></li>
                    </ul>

                </div>

                <div class="col-lg-4 col-md-6">

                    <h5>Kata Hari Ini</h5>

                    <p class="footer-quote">
                        "Membaca adalah perjalanan tanpa batas
                        menuju dunia pengetahuan."
                    </p>

                </div>

            </div>

            <div class="footer-bottom">
                <p>© 2026 Perpustakaan Indonesia. All rights reserved.</p>
                <span>Made By Muhaimin</span>
            </div>

        </div>

    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
