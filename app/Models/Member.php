<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $table = 'member';

    protected $fillable = [
        'nama_member',
        'email',
        'no_telepon',
        'tanggal_lahir',
        'foto_member',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'member_id');
    }
}
