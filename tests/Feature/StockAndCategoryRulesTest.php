<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Member;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockAndCategoryRulesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withSession(['user_id' => 1]);
    }

    public function test_deleting_category_keeps_books(): void
    {
        $kategori = Kategori::create(['nama_kategori' => 'Novel']);
        $buku = Buku::create([
            'kategori_id' => $kategori->id,
            'nama_buku' => 'Dilan 1990',
            'isbn' => '123456',
            'stok' => 2,
        ]);

        $this->delete(route('kategori.destroy', $kategori));

        $this->assertDatabaseHas('buku', [
            'id' => $buku->id,
            'kategori_id' => null,
        ]);
    }

    public function test_borrowing_reduces_stock_and_blocks_unavailable_book(): void
    {
        $buku = Buku::create([
            'kategori_id' => Kategori::create(['nama_kategori' => 'Komputer'])->id,
            'nama_buku' => 'Laravel Dasar',
            'isbn' => 'ABC-001',
            'stok' => 2,
        ]);
        $member = Member::create([
            'nama_member' => 'Andi',
            'email' => 'andi@example.com',
            'no_telepon' => '08123456789',
            'tanggal_lahir' => '2000-01-01',
        ]);

        $payload = [
            'member_id' => $member->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => '2026-11-17',
            'tanggal_jatuh_tempo' => '2026-12-01',
        ];

        $response = $this->post(route('peminjaman.store'), $payload);

        $response->assertRedirect(route('peminjaman.index'));
        $this->assertSame(1, $buku->fresh()->stok);

        $response2 = $this->post(route('peminjaman.store'), $payload);

        $response2->assertRedirect(route('peminjaman.index'));
        $this->assertSame(0, $buku->fresh()->stok);

        $response3 = $this->from(route('peminjaman.create'))->post(route('peminjaman.store'), $payload);

        $response3->assertSessionHasErrors('buku_id');
    }

    public function test_returning_a_book_restores_stock_only_once(): void
    {
        $buku = Buku::create([
            'kategori_id' => Kategori::create(['nama_kategori' => 'Teknik'])->id,
            'nama_buku' => 'PHP Mastery',
            'isbn' => 'XYZ-111',
            'stok' => 2,
        ]);

        $member = Member::create([
            'nama_member' => 'Sari',
            'email' => 'sari@example.com',
            'no_telepon' => '08123456787',
            'tanggal_lahir' => '1999-03-03',
        ]);

        $this->post(route('peminjaman.store'), [
            'member_id' => $member->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => '2026-11-17',
            'tanggal_jatuh_tempo' => '2026-12-01',
        ]);

        $peminjaman = Peminjaman::firstOrFail();
        $this->assertSame(1, $buku->fresh()->stok);

        $this->patch(route('peminjaman.return', $peminjaman));

        $this->assertSame(2, $buku->fresh()->stok);
        $this->assertSame('dikembalikan', $peminjaman->fresh()->status);

        $this->patch(route('peminjaman.return', $peminjaman));
        $this->assertSame(2, $buku->fresh()->stok);
    }

    public function test_archiving_member_keeps_active_loan_and_does_not_restore_stock(): void
    {
        $buku = Buku::create([
            'kategori_id' => Kategori::create(['nama_kategori' => 'Teknik'])->id,
            'nama_buku' => 'PHP Mastery',
            'isbn' => 'XYZ-111',
            'stok' => 2,
        ]);
        $member = Member::create([
            'nama_member' => 'Sari',
            'email' => 'sari@example.com',
            'no_telepon' => '08123456787',
            'tanggal_lahir' => '1999-03-03',
        ]);

        $this->post(route('peminjaman.store'), [
            'member_id' => $member->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => '2026-11-17',
            'tanggal_jatuh_tempo' => '2026-12-01',
        ]);

        $this->delete(route('member.destroy', $member));

        $this->assertSame(1, $buku->fresh()->stok);
        $this->assertDatabaseHas('peminjaman', [
            'member_id' => $member->id,
            'status' => 'dipinjam',
        ]);
    }

    public function test_deleting_book_keeps_member_data(): void
    {
        $buku = Buku::create([
            'kategori_id' => Kategori::create(['nama_kategori' => 'Sains'])->id,
            'nama_buku' => 'Fisika Dasar',
            'isbn' => 'S-001',
            'stok' => 3,
        ]);

        $member = Member::create([
            'nama_member' => 'Dewi',
            'email' => 'dewi@example.com',
            'no_telepon' => '08123456786',
            'tanggal_lahir' => '2000-04-04',
        ]);

        $this->delete(route('buku.destroy', $buku));

        $this->assertDatabaseHas('member', ['id' => $member->id, 'email' => 'dewi@example.com']);
    }

    public function test_book_with_an_active_loan_cannot_be_deleted(): void
    {
        $buku = Buku::create([
            'kategori_id' => Kategori::create(['nama_kategori' => 'Sains'])->id,
            'nama_buku' => 'Fisika Dasar',
            'isbn' => 'S-002',
            'stok' => 1,
        ]);
        $member = Member::create([
            'nama_member' => 'Dewi',
            'email' => 'dewi@example.com',
            'no_telepon' => '08123456786',
            'tanggal_lahir' => '2000-04-04',
        ]);
        $this->post(route('peminjaman.store'), [
            'member_id' => $member->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => '2026-11-17',
            'tanggal_jatuh_tempo' => '2026-12-01',
        ]);

        $this->delete(route('buku.destroy', $buku))
            ->assertRedirect(route('buku.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('buku', ['id' => $buku->id]);
    }
}
