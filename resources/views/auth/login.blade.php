@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <section class="login-split">
        <div class="login-form-panel">
            <div class="login-form-content">
                <h1 class="login-title mb-4">Login Perpustakaan</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100">Masuk</button>
                </form>
            </div>

            <aside class="login-contact" aria-labelledby="login-contact-title">
                <h2 id="login-contact-title" class="login-contact-title">Belum punya akun?</h2>
                <p class="login-contact-copy">Hubungi admin perpustakaan untuk mendapatkan akun login.</p>
                <a class="login-contact-link" href="mailto:muhaimin@perpustakaan.id">
                    muhaimin@perpustakaan.id
                </a>
            </aside>
        </div>

        <div class="login-photo-panel">
            <img src="{{ asset('images/perpus.jpg') }}" alt="Rak buku di perpustakaan">
        </div>

    </section>
@endsection
