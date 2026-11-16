<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Member;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalBuku' => Buku::count(),
            'stokTersedia' => Buku::sum('stok'),
            'totalKategori' => Kategori::count(),
            'totalMember' => Member::count(),
        ]);
    }
}
