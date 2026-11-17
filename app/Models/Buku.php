<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    protected $fillable = [
        'kategori_id',
        'nama_buku',
        'isbn',
        'stok',
        'foto_buku',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function member()
    {
        return $this->hasMany(Member::class, 'buku_id');
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'buku_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }
}
