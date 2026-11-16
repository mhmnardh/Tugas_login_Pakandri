<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAuthenticated;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MemberController;


Route::get('/', function () {
    if (session()->has('user_id')) {
        return redirect()->route('admin.dashboard');
    }

    return view('class.index');
})->name('class.index');

Route::view('/public', 'class.index')->name('public.home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::resource('kategori', KategoriController::class)->only('index');
Route::resource('buku', BukuController::class)->only('index');
Route::resource('member', MemberController::class)->only('index');

Route::middleware(EnsureAuthenticated::class)->group(function () {
    Route::get('/admin/dashboard', DashboardController::class)->name('admin.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('kategori', KategoriController::class)->except('index');
    Route::resource('buku', BukuController::class)->except('index');
    Route::resource('member', MemberController::class)->except('index');
});
