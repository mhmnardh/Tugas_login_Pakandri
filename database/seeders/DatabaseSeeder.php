<?php

namespace Database\Seeders;

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
    }
}
