<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', ' Perpustakaan ')</title>
    <title>Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <nav class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"> <a href="/"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none"> <svg
                    class="bi me-2" width="40" height="32" aria-hidden="true">
                    <use xlink:href="#bootstrap"></use>
                </svg> <span class="fs-3"> Perpustakaan Indonesia</span> </a>
            <ul class="nav nav-pills gap-2 ">
                <li class="nav-item">
                    <a href="{{ route('class.index') }}" class="nav-link fw-semibold" aria-current="page">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kategori.index') ? 'active fw-semibold' : '' }}"
                        href="{{ route('kategori.index') }}">kategori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('buku.index') ? 'active fw-semibold' : '' }}"
                        href="{{ route('buku.index') }}">Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('member.index') ? 'active fw-semibold' : '' }}"
                        href="{{ route('member.index') }}">member</a>
                </li>
                @if (session('user_id'))
                    <li class="nav-item">
                        <a href="#" class="nav-link text-danger"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                    </li>
                @endif
            </ul>
        </header>
    </nav>

    <div>
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <footer>
        <div class="container">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <p class="col-md-4 mb-0 text-body-secondary">© 2026 Muhaimin</p> <a href="/"
                    class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none"
                    aria-label="Bootstrap"> <svg class="bi me-2" width="40" height="32" aria-hidden="true">
                        <use xlink:href="#bootstrap"></use>
                    </svg> </a>
                <ul class="nav col-md-4 justify-content-end">
                    <li class="nav-item"><a href="{{ route('class.index') }}"
                            class="nav-link px-2 text-body-secondary">Home</a></li>
                    <li class="nav-item"><a href="{{ route('kategori.index') }}"
                            class="nav-link px-2 text-body-secondary">Kategori</a></li>
                    <li class="nav-item"><a href="{{ route('buku.index') }}"
                            class="nav-link px-2 text-body-secondary">Buku</a></li>
                    <li class="nav-item"><a href="{{ route('member.index') }}"
                            class="nav-link px-2 text-body-secondary">Member</a></li>
                </ul>
            </footer>
        </div>
    </footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
</script>

</html>
