<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin | Perpustakaan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        :root {
            --admin-ink: #202a27;
            --admin-paper: #f4f6f2;
            --admin-green: #167a5b;
            --admin-line: #e2e8e2;
        }

        body {
            min-height: 100vh;
            background: var(--admin-paper);
            color: var(--admin-ink);
        }

        .admin-sidebar {
            width: 252px;
            min-height: 100vh;
            background: #202a27;
        }

        .admin-brand-mark {
            display: grid;
            width: 38px;
            height: 38px;
            place-items: center;
            border-radius: 10px;
            background: #d7ed72;
            color: #202a27;
            font-weight: 800;
        }

        .admin-sidebar .nav-link {
            color: #c3cfca;
            border-radius: 8px;
            padding: 10px 12px;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            background: #34443e;
            color: #fff;
        }

        .admin-sidebar .nav-link.active::before {
            content: '';
            display: inline-block;
            width: 7px;
            height: 7px;
            margin: 0 10px 1px 0;
            border-radius: 50%;
            background: #d7ed72;
        }

        .admin-main {
            width: min(100%, 1440px);
            padding: 34px clamp(20px, 4vw, 56px);
        }

        .admin-stat {
            min-height: 142px;
            border: 1px solid var(--admin-line);
            border-radius: 8px;
            background: #fff;
        }

        .admin-stat-value {
            color: var(--admin-ink);
            font-size: 2rem;
            line-height: 1;
            font-weight: 700;
        }

        .admin-action {
            display: flex;
            min-height: 62px;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--admin-line);
            color: var(--admin-ink);
            text-decoration: none;
        }

        .admin-action:last-child {
            border-bottom: 0;
        }

        .admin-action:hover {
            color: var(--admin-green);
        }

        .admin-topbar {
            border-bottom: 1px solid var(--admin-line);
        }

        @media (max-width: 767.98px) {
            .admin-sidebar {
                width: 100%;
                min-height: auto;
            }

            .admin-sidebar .nav {
                flex-direction: row !important;
                flex-wrap: wrap;
            }

            .admin-main {
                padding: 26px 18px;
            }
        }
    </style>
</head>

<body>
    <div class="d-md-flex min-vh-100">
        <aside class="admin-sidebar d-flex flex-column p-3 p-lg-4">
            <a href="{{ route('admin.dashboard') }}"
                class="d-flex align-items-center gap-3 mb-4 text-decoration-none text-white">
                <span class="admin-brand-mark">P</span>
                <span class="lh-sm">
                    <strong class="d-block">Perpustakaan</strong>
                    <small class="text-white-50">ADMINISTRASI</small>
                </span>
            </a>

            <small class="text-uppercase text-white-50 fw-semibold mb-2">Menu</small>
            <nav class="nav nav-pills flex-column gap-1">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}"
                    href="{{ route('buku.index') }}">Buku</a>
                <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}"
                    href="{{ route('kategori.index') }}">Kategori</a>
                <a class="nav-link {{ request()->routeIs('member.*') ? 'active' : '' }}"
                    href="{{ route('member.index') }}">Member</a>
            </nav>

            <div class="mt-auto pt-4">
                <a href="{{ route('public.home') }}" class="nav-link px-2 mb-2 text-white-50">Lihat halaman publik</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-light w-100" type="submit">Keluar dari admin</button>
                </form>
            </div>
        </aside>

        <div class="flex-grow-1">
            <header class="admin-topbar d-flex justify-content-between align-items-center bg-white px-4 px-lg-5 py-3">
                <span class="small text-secondary">Panel pengelolaan perpustakaan</span>
                <span class="small fw-semibold">{{ session('user_name', 'Administrator') }}</span>
            </header>

            <main class="admin-main mx-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
