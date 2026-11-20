<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $email = config('services.admin.email');
        $password = config('services.admin.password');

        if (app()->environment('production')) {
            if (! is_string($email) || trim($email) === '' || ! is_string($password) || $password === '') {
                throw new RuntimeException('Set ADMIN_EMAIL and ADMIN_PASSWORD before seeding production.');
            }
        } else {
            $email = $email ?: '123@123.com';
            $password = $password ?: '123';
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Muhaimin',
                'password' => Hash::make($password),
            ]
        );

        $kategoriFiksi = Kategori::firstOrCreate(['nama_kategori' => 'Fiksi']);
        $kategoriNonFiksi = Kategori::firstOrCreate(['nama_kategori' => 'Non-Fiksi']);
        $kategoriPendidikan = Kategori::firstOrCreate(['nama_kategori' => 'Pendidikan']);

        Buku::updateOrCreate(
            ['isbn' => '9786020323459'],
            [
                'kategori_id' => $kategoriFiksi->id,
                'nama_buku' => 'Laskar Pelangi',
                'stok' => 10,
            ]
        );

        Buku::updateOrCreate(
            ['isbn' => '9786020333076'],
            [
                'kategori_id' => $kategoriFiksi->id,
                'nama_buku' => 'Negeri 5 Menara',
                'stok' => 8,
            ]
        );

        Buku::updateOrCreate(
            ['isbn' => '9786024245138'],
            [
                'kategori_id' => $kategoriNonFiksi->id,
                'nama_buku' => 'Filosofi Teras',
                'stok' => 12,
            ]
        );

        Buku::updateOrCreate(
            ['isbn' => '9786020523316'],
            [
                'kategori_id' => $kategoriPendidikan->id,
                'nama_buku' => 'Dasar-Dasar Pemrograman',
                'stok' => 6,
            ]
        );

        Member::updateOrCreate(
            ['email' => 'andi@example.com'],
            [
                'nama_member' => 'Andi Saputra',
                'no_telepon' => '081234567801',
                'tanggal_lahir' => '2005-02-14',
            ]
        );

        Member::updateOrCreate(
            ['email' => 'siti@example.com'],
            [
                'nama_member' => 'Siti Nurhaliza',
                'no_telepon' => '081234567802',
                'tanggal_lahir' => '2004-08-21',
            ]
        );

        Member::updateOrCreate(
            ['email' => 'budi@example.com'],
            [
                'nama_member' => 'Budi Santoso',
                'no_telepon' => '081234567803',
                'tanggal_lahir' => '2006-01-09',
            ]
        );
    }
}
