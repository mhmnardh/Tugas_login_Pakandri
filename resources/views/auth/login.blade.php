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

                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>
            </div>
        </div>

        <div class="login-photo-panel">
            <img src="{{ asset('images/perpus.jpg') }}" alt="Rak buku di perpustakaan">
        </div>
    </section>
@endsection
