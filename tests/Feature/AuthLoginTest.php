<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        $user = User::create([
            'name' => 'Muhaimin',
            'email' => 'muha@gmail.com',
            'password' => Hash::make('123'),
        ]);

        $response = $this->from(route('login'))->post(route('login.submit'), [
            'email' => 'muha@gmail.com',
            'password' => '123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertEquals($user->id, session('user_id'));
    }

    public function test_admin_dashboard_requires_login(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_home_redirects_logged_in_users_to_admin_dashboard(): void
    {
        $this->withSession(['user_id' => 1]);

        $this->get(route('class.index'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_home_remains_public_for_guests(): void
    {
        $this->get(route('class.index'))
            ->assertOk()
            ->assertViewIs('class.index');
    }

    public function test_admin_can_open_public_home_without_leaving_session(): void
    {
        $this->withSession(['user_id' => 1, 'user_name' => 'Admin']);

        $this->get(route('public.home'))
            ->assertOk()
            ->assertViewIs('class.index')
            ->assertSee('Membuka jendela dunia')
            ->assertSee('Logout')
            ->assertSessionHas('user_id', 1);
    }

    public function test_logout_returns_user_to_public_home(): void
    {
        $this->withSession(['user_id' => 1, 'user_name' => 'Admin']);

        $this->post(route('logout'))
            ->assertRedirect(route('class.index'))
            ->assertSessionMissing('user_id');

        $this->get(route('class.index'))
            ->assertOk()
            ->assertViewIs('class.index');
    }

    public function test_admin_dashboard_shows_library_totals(): void
    {
        $this->withSession(['user_id' => 1, 'user_name' => 'Admin']);

        $response = $this->get(route('admin.dashboard'));

        $response->assertOk()
            ->assertViewHas('totalBuku', 0)
            ->assertViewHas('stokTersedia', 0)
            ->assertViewHas('totalKategori', 0)
            ->assertViewHas('totalMember', 0);
    }

    public function test_admin_navigation_is_visible_on_resource_pages(): void
    {
        $this->withSession(['user_id' => 1, 'user_name' => 'Admin']);

        $kategori = Kategori::create(['nama_kategori' => 'Novel']);
        $buku = Buku::create([
            'kategori_id' => $kategori->id,
            'nama_buku' => 'Buku Tes',
            'isbn' => 'TEST-001',
            'stok' => 2,
        ]);
        $member = Member::create([
            'buku_id' => $buku->id,
            'nama_member' => 'Member Tes',
            'email' => 'member@example.com',
            'no_telepon' => '08123456789',
            'tanggal_lahir' => '2000-01-01',
        ]);

        $pages = [
            route('buku.index'),
            route('buku.create'),
            route('buku.edit', $buku),
            route('kategori.index'),
            route('kategori.create'),
            route('kategori.edit', $kategori),
            route('member.index'),
            route('member.create'),
            route('member.edit', $member),
        ];

        foreach ($pages as $page) {
            $this->get($page)
                ->assertOk()
                ->assertSee('Keluar dari admin');
        }
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

        $response->assertOk()
            ->assertSee('Daftar Kategori')
            ->assertDontSee('Tambah Kategori Baru');
    }

    public function test_category_login_prompt_is_hidden_for_admin(): void
    {
        $this->withSession(['user_id' => 1]);

        $this->get(route('kategori.index'))
            ->assertOk()
            ->assertSee('Tambah Kategori Baru');
    }

    public function test_create_route_requires_login(): void
    {
        $response = $this->get(route('kategori.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_peminjaman_routes_require_login(): void
    {
        $this->get(route('peminjaman.index'))
            ->assertRedirect(route('login'));

        $this->get(route('peminjaman.create'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_open_peminjaman_pages(): void
    {
        $this->withSession(['user_id' => 1, 'user_name' => 'Admin']);

        $this->get(route('peminjaman.index'))
            ->assertOk()
            ->assertSee('Peminjaman');

        $this->get(route('peminjaman.create'))
            ->assertOk()
            ->assertSee('Catat Peminjaman');
    }
}
