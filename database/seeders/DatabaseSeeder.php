<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('secret123'),
            ]
        );
        User::updateOrCreate(
            ['email' => 'Muhaimin@gmail.com'],
            [
                'name' => 'Muhaimin',
                'password' => Hash::make('Muhaimin'),
            ]
        );
    }
}
