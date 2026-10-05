<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    protected $fillable = [
        'buku_id',
        'nama_member',
        'email',
        'no_telepon',
        'tanggal_lahir',
        'foto_member'
    ];

    protected static function booted(): void
    {
        static::created(function (self $member) {
            if ($member->buku_id) {
                Buku::whereKey($member->buku_id)
                    ->where('stok', '>', 0)
                    ->decrement('stok');
            }
        });

        static::updated(function (self $member) {
            $oldBukuId = $member->getOriginal('buku_id');
            $newBukuId = $member->buku_id;

            if ($oldBukuId && $oldBukuId != $newBukuId) {
                Buku::whereKey($oldBukuId)->increment('stok');
            }

            if ($newBukuId && $newBukuId != $oldBukuId) {
                Buku::whereKey($newBukuId)
                    ->where('stok', '>', 0)
                    ->decrement('stok');
            }
        });

        static::deleted(function (self $member) {
            if ($member->buku_id) {
                Buku::whereKey($member->buku_id)->increment('stok');
            }
        });
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
