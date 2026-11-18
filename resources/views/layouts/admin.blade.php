<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin | Perpustakaan')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --admin-ink: var(--text-primary);
            --admin-paper: var(--bg-primary);
            --admin-accent: var(--accent-hover);
            --admin-accent-strong: var(--accent-hover-strong);
            --admin-sidebar: var(--bg-secondary);
            --admin-line: var(--border-color);
            --admin-muted: var(--text-secondary-strong);
        }

        body {
            min-height: 100vh;
            background: var(--admin-paper);
            color: var(--admin-ink);
            font-family: var(--font-body);
        }

        .admin-sidebar {
            width: 252px;
            flex: 0 0 252px;
            min-height: 100vh;
            background: var(--admin-sidebar);
            box-shadow: 8px 0 30px rgb(45 49 52 / 7%);
        }

        .admin-brand-mark {
            display: grid;
            width: 38px;
            height: 38px;
            place-items: center;
            border-radius: 10px;
            background: var(--accent-soft);
            color: var(--admin-ink);
            font-weight: 800;
        }

        .admin-sidebar .nav-link {
            color: var(--text-secondary-strong);
            border-radius: 8px;
            padding: 10px 12px;
            transition: background-color 160ms ease, color 160ms ease;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            background: color-mix(in srgb, var(--accent-primary) 14%, var(--bg-secondary));
            color: var(--text-primary);
        }

        .admin-sidebar .nav-link.active::before {
            content: '';
            display: inline-block;
            width: 7px;
            height: 7px;
            margin: 0 10px 1px 0;
            border-radius: 50%;
            background: var(--accent-primary);
        }

        .admin-sidebar .btn-outline-primary {
            --bs-btn-hover-color: var(--accent-foreground);
            --bs-btn-active-color: var(--accent-foreground);
        }

        .admin-main {
            width: auto;
            min-width: 0;
            margin: 24px !important;
            padding: clamp(24px, 3vw, 44px);
            border: 1px solid var(--admin-line);
            border-radius: 3px;
            background: var(--surface-light);
        }

        .admin-stat {
            min-height: 154px;
            border: 1px solid var(--admin-line);
            border-radius: 12px;
            background: var(--bg-secondary);
            box-shadow: var(--shadow-card);
            transition: transform 160ms ease, box-shadow 160ms ease;
        }

        .admin-stat:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-card-hover);
        }

        .admin-stat-icon {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            place-items: center;
            border-radius: 12px;
            font-size: 19px;
        }

        .admin-stat-value {
            color: var(--admin-ink);
            font-family: var(--font-display);
            font-size: 2.15rem;
            line-height: 1;
            font-weight: 800;
        }

        .admin-dashboard-title {
            font-family: var(--font-display);
            font-weight: 800;
        }

        .admin-eyebrow {
            color: var(--admin-accent);
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .admin-action-list {
            overflow: hidden;
            border: 1px solid var(--admin-line);
            border-radius: 12px;
            background: var(--bg-secondary);
            box-shadow: var(--shadow-card);
        }

        .admin-action-icon {
            display: grid;
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            place-items: center;
            border-radius: 10px;
            background: var(--accent-soft);
            color: var(--admin-accent);
        }

        .admin-icon-stock {
            background: color-mix(in srgb, var(--text-secondary) 14%, var(--bg-secondary));
            color: var(--text-secondary-strong);
        }

        .admin-icon-category {
            background: color-mix(in srgb, var(--accent-primary) 10%, var(--bg-secondary));
            color: var(--accent-hover);
        }

        .admin-icon-member {
            background: color-mix(in srgb, var(--accent-primary) 18%, var(--bg-secondary));
            color: var(--accent-hover);
        }

        .admin-action {
            display: flex;
            min-height: 72px;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 16px;
            border-bottom: 1px solid var(--admin-line);
            color: var(--admin-ink);
            text-decoration: none;
            transition: background-color 160ms ease;
        }

        .admin-action:last-child {
            border-bottom: 0;
        }

        .admin-action:hover {
            background: color-mix(in srgb, var(--accent-primary) 6%, var(--bg-secondary));
            color: var(--admin-ink);
        }

        .admin-action:hover .admin-action-arrow {
            transform: translateX(3px);
            color: var(--admin-accent);
        }

        .admin-action-arrow {
            color: var(--admin-muted);
            transition: transform 160ms ease, color 160ms ease;
        }

        .admin-shortcut {
            display: flex;
            min-height: 84px;
            align-items: center;
            gap: 14px;
            padding: 16px;
            border: 1px solid var(--admin-line);
            border-radius: 12px;
            background: var(--bg-secondary);
            color: var(--admin-ink);
            text-decoration: none;
            box-shadow: var(--shadow-card);
            transition: border-color 160ms ease, transform 160ms ease;
        }

        .admin-shortcut:hover {
            transform: translateY(-2px);
            border-color: var(--accent-primary);
            color: var(--admin-accent);
        }

        .admin-topbar {
            position: relative;
            flex-wrap: wrap;
            gap: 10px 20px;
            background: var(--primary-dark);
            color: var(--text);
            border-bottom: 1px solid var(--admin-line);
            box-shadow: 0 2px 8px rgb(45 49 52 / 3%);
        }

        .admin-topbar::before {
            position: absolute;
            inset: 0 0 auto;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-hover));
            content: '';
        }

        .btn-admin-primary {
            border-color: var(--accent-primary);
            background: var(--accent-primary);
            color: var(--accent-foreground);
        }

        .btn-admin-primary:hover,
        .btn-admin-primary:focus-visible {
            border-color: var(--admin-accent-strong);
            background: var(--admin-accent-strong);
            color: var(--accent-foreground);
        }

        .admin-avatar {
            display: grid;
            width: 34px;
            height: 34px;
            place-items: center;
            border-radius: 50%;
            background: var(--gold);
            color: var(--primary-dark);
            font-size: .8rem;
            font-weight: 700;
        }

        @media (max-width: 767.98px) {
            .admin-sidebar {
                width: 100%;
                flex-basis: auto;
                min-height: auto;
                padding: 16px !important;
            }

            .admin-sidebar .nav {
                flex-direction: row !important;
                flex-wrap: wrap;
            }

            .admin-sidebar .nav .nav-link {
                flex: 1 1 auto;
                text-align: center;
            }

            .admin-main {
                margin: 16px !important;
                padding: 24px 16px 30px;
            }

            .admin-topbar {
                padding-right: 18px !important;
                padding-left: 18px !important;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>
    <div class="d-md-flex min-vh-100">
        <aside class="admin-sidebar d-flex flex-column p-3 p-lg-4">
            <a href="{{ route('admin.dashboard') }}"
                class="d-flex align-items-center gap-3 mb-4 text-decoration-none text-primary">
                <span class="admin-brand-mark">P</span>
                <span class="lh-sm">
                    <strong class="d-block">Perpustakaan</strong>
                    <small class="text-secondary">ADMINISTRASI</small>
                </span>
            </a>

            <small class="text-uppercase text-secondary fw-semibold mb-2">Menu</small>
            <nav class="nav nav-pills flex-column gap-1">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}"
                    href="{{ route('buku.index') }}">Buku</a>
                <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}"
                    href="{{ route('kategori.index') }}">Kategori</a>
                <a class="nav-link {{ request()->routeIs('member.*') ? 'active' : '' }}"
                    href="{{ route('member.index') }}">Member</a>
                <a class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}"
                    href="{{ route('peminjaman.index') }}">Peminjaman</a>
            </nav>

            <div class="mt-auto pt-4">
                <a href="{{ route('public.home') }}" class="nav-link px-2 mb-2 text-secondary">Lihat halaman publik</a>
                <form action="{{ route('logout') }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
                    @csrf
                    <button class="btn btn-outline-primary w-100" type="submit">Keluar dari admin</button>
                </form>
            </div>
        </aside>

        <div class="flex-grow-1">
            <header class="admin-topbar d-flex justify-content-between align-items-center px-4 px-lg-5 py-3">
                <span class="small text-secondary">Panel pengelolaan perpustakaan</span>
                <span class="d-flex align-items-center gap-2 small fw-semibold">
                    <span class="admin-avatar"
                        aria-hidden="true">{{ mb_strtoupper(mb_substr(session('user_name', 'Administrator'), 0, 1)) }}</span>
                    {{ session('user_name', 'Administrator') }}
                </span>
            </header>

            <main class="admin-main mx-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
