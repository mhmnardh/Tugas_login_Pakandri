<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct()
    {
        // tidak ada pemeriksaan login di sini agar halaman login tetap bisa dibuka
    }

    public function showLoginForm(): View|RedirectResponse
    {
        if (session()->has('user_id')) {
            return redirect()->route('kategori.index');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput();
        }

        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
        ]);

        return redirect()->route('kategori.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['user_id', 'user_name']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
