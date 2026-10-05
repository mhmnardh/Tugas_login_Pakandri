<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_without_auth_middleware(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->from(route('login'))->post(route('login.submit'), [
            'email' => 'admin@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('kategori.index'));
        $this->assertEquals($user->id, session('user_id'));
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->from(route('login'))->post(route('login.submit'), [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
    }

    public function test_guest_can_view_data_without_login(): void
    {
        $response = $this->get(route('kategori.index'));

        $response->assertOk();
    }

    public function test_create_route_requires_login(): void
    {
        $response = $this->get(route('kategori.create'));

        $response->assertRedirect(route('login'));
    }
}
