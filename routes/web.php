<?php

//use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\KopdesController;
//use App\Http\Controllers\ManagerController;


//Route::resource('manager', ManagerController::class);
//Route::resource('kopdes' , KopdesController::class);
//Route::resource('kopdes', KopdesController::class)
//->parameters(['kopdes' => 'kopdes']);

//Route::get('/', function () {
//return view('class.index');
//})->name('class.index');



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MemberController;


Route::get('/', function () {
    return view('class.index');
})->name('class.index');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('kategori', KategoriController::class);
Route::resource('buku', BukuController::class);
Route::resource('member', MemberController::class);
